<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Assignment;
use App\Models\ClassModel;
use App\Models\ClassEnrollment;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        if ($user->role === 'teacher') {
            $classes = ClassModel::where('teacher_id', $user->id)->pluck('id');
        } else {
            $classes = ClassEnrollment::where('student_id', $user->id)->pluck('class_id');
        }

        // Get week parameter or use current week
        $weekStart = $request->get('week') ? Carbon::parse($request->get('week'))->setTimezone(config('app.timezone')) : Carbon::now(config('app.timezone'));
        $startOfWeek = $weekStart->copy()->startOfWeek();
        $endOfWeek = $weekStart->copy()->endOfWeek();

        $assignments = Assignment::whereIn('class_id', $classes)
            ->whereBetween('due_date', [$startOfWeek, $endOfWeek])
            ->with(['class'])
            ->orderBy('due_date')
            ->get();

        // Group assignments by day
        $weeklyAssignments = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);
            $weeklyAssignments[$date->format('Y-m-d')] = [
                'date' => $date,
                'assignments' => $assignments->filter(function ($assignment) use ($date) {
                    return $assignment->due_date->format('Y-m-d') === $date->format('Y-m-d');
                })
            ];
        }

        return view('calendar.index', compact('weeklyAssignments', 'startOfWeek', 'endOfWeek'));
    }
}

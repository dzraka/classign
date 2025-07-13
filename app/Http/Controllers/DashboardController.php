<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ClassModel;
use App\Models\ClassEnrollment;
use App\Models\Assignment;
use App\Models\Submission;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'teacher') {
            $classes = ClassModel::where('teacher_id', $user->id)
                ->withCount(['students', 'assignments', 'materials'])->get();
            $upcomingAssignments = Assignment::whereIn('class_id', $classes->pluck('id'))
                ->where('due_date', '>', Carbon::now(config('app.timezone')))
                ->orderBy('due_date')
                ->limit(5)
                ->get();
                
            // Count submissions pending review
            $pendingReviews = Submission::whereHas('assignment', function($query) use ($user) {
                $query->where('teacher_id', $user->id);
            })->whereNotNull('submitted_at')->whereNull('score')->count();
            
            $pendingAssignments = 0; // Not applicable for teachers
                
        } else {
            $enrolledClassIds = ClassEnrollment::where('student_id', $user->id)->pluck('class_id');
            $classes = ClassModel::whereIn('id', $enrolledClassIds)
                ->withCount(['students', 'assignments', 'materials'])->get();
            
            // Get upcoming assignments that haven't been submitted
            $upcomingAssignments = Assignment::whereIn('class_id', $enrolledClassIds)
                ->where('due_date', '>', Carbon::now(config('app.timezone')))
                ->whereDoesntHave('submissions', function($query) use ($user) {
                    $query->where('student_id', $user->id)
                          ->whereNotNull('submitted_at');
                })
                ->orderBy('due_date')
                ->limit(5)
                ->get();
                
            // Count unsubmitted assignments (more accurate)
            $pendingAssignments = Assignment::whereIn('class_id', $enrolledClassIds)
                ->whereDoesntHave('submissions', function($query) use ($user) {
                    $query->where('student_id', $user->id)
                          ->whereNotNull('submitted_at');
                })
                ->count();
            
            $pendingReviews = 0; // Not applicable for students
        }

        return view('dashboard', compact('classes', 'upcomingAssignments', 'pendingReviews', 'pendingAssignments'));
    }
}

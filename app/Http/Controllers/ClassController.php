<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\ClassModel;
use App\Models\ClassEnrollment;

class ClassController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'teacher') {
            $classes = ClassModel::where('teacher_id', $user->id)->withCount('students')->get();
        } else {
            $enrolledClassIds = ClassEnrollment::where('student_id', $user->id)->pluck('class_id');
            $classes = ClassModel::whereIn('id', $enrolledClassIds)->withCount('students')->get();
        }

        return view('classes.index', compact('classes'));
    }

    public function create()
    {
        if (!(Auth::user()->role === 'teacher')) {
            abort(403, 'Hanya pengajar yang dapat membuat kelas.');
        }

        return view('classes.create');
    }

    public function store(Request $request)
    {
        if (!(Auth::user()->role === 'teacher')) {
            abort(403, 'Hanya pengajar yang dapat membuat kelas.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $class = ClassModel::create([
            'name' => $request->name,
            'description' => $request->description,
            'teacher_id' => Auth::id(),
            'class_code' => strtoupper(Str::random(6)),
        ]);

        return redirect()->route('classes.show', $class)->with('success', 'Kelas berhasil dibuat!');
    }

    public function show(ClassModel $class)
    {
        $user = Auth::user();
        
        // Check access
        if ($user->role === 'teacher' && $class->teacher_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke kelas ini.');
        }
        
        if ($user->role === 'student' && !$class->isEnrolledBy($user)) {
            abort(403, 'Anda tidak terdaftar di kelas ini.');
        }

        $materials = $class->materials()->latest()->limit(5)->get();
        $assignments = $class->assignments()->latest()->limit(5)->get();

        return view('classes.show', compact('class', 'materials', 'assignments'));
    }

    public function join()
    {
        if (!(Auth::user()->role === 'student')) {
            abort(403, 'Hanya siswa yang dapat bergabung ke kelas.');
        }

        return view('classes.join');
    }

    public function joinClass(Request $request)
    {
        if (!(Auth::user()->role === 'student')) {
            abort(403, 'Hanya siswa yang dapat bergabung ke kelas.');
        }

        $request->validate([
            'class_code' => 'required|string|size:6|exists:classes,class_code',
        ]);

        $class = ClassModel::where('class_code', $request->class_code)->first();
        $user = Auth::user();

        // Check if already enrolled
        if ($class->isEnrolledBy($user)) {
            return back()->withErrors(['class_code' => 'Anda sudah terdaftar di kelas ini.']);
        }

        ClassEnrollment::create([
            'class_id' => $class->id,
            'student_id' => $user->id,
        ]);

        return redirect()->route('classes.show', $class)->with('success', 'Berhasil bergabung ke kelas!');
    }

    public function edit(ClassModel $class)
    {
        if (!(Auth::user()->role === 'teacher') || $class->teacher_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit kelas ini.');
        }

        return view('classes.edit', compact('class'));
    }

    public function update(Request $request, ClassModel $class)
    {
        if (!(Auth::user()->role === 'teacher') || $class->teacher_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit kelas ini.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'subject' => 'required|string|max:100',
        ]);

        $class->update([
            'name' => $request->name,
            'description' => $request->description,
            'subject' => $request->subject,
        ]);

        return redirect()->route('classes.show', $class)->with('success', 'Kelas berhasil diperbarui!');
    }

    public function destroy(ClassModel $class)
    {
        if (!(Auth::user()->role === 'teacher') || $class->teacher_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus kelas ini.');
        }

        $class->delete();

        return redirect()->route('classes.index')->with('success', 'Kelas berhasil dihapus!');
    }
}

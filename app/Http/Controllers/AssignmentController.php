<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\ClassModel;
use App\Models\Assignment;
use App\Models\Submission;

class AssignmentController extends Controller
{
    public function index(ClassModel $class)
    {
        $user = Auth::user();
        
        // Check access
        if ($user->role === 'teacher' && $class->teacher_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke kelas ini.');
        }
        
        if ($user->role === 'student' && !$class->isEnrolledBy($user)) {
            abort(403, 'Anda tidak terdaftar di kelas ini.');
        }

        $assignments = $class->assignments()->orderBy('due_date', 'desc')->get();

        if ($user->role === 'student') {
            // Add submission status for student
            foreach ($assignments as $assignment) {
                $assignment->user_submission = $assignment->getSubmissionByStudent($user->id);
            }
        }

        return view('assignments.index', compact('class', 'assignments'));
    }

    public function create(Request $request)
    {
        if (!(Auth::user()->role === 'teacher')) {
            abort(403, 'Hanya pengajar yang dapat membuat tugas.');
        }

        $classId = $request->get('class_id');
        $class = ClassModel::findOrFail($classId);

        if ($class->teacher_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk membuat tugas di kelas ini.');
        }

        return view('assignments.create', compact('class'));
    }

    public function store(Request $request)
    {
        if (!(Auth::user()->role === 'teacher')) {
            abort(403, 'Hanya pengajar yang dapat membuat tugas.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date|after:now',
            'max_score' => 'required|integer|min:1|max:1000',
            'class_id' => 'required|exists:classes,id',
        ]);

        $class = ClassModel::findOrFail($request->class_id);

        if ($class->teacher_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk membuat tugas di kelas ini.');
        }

        $assignment = Assignment::create([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'max_score' => $request->max_score,
            'class_id' => $request->class_id,
            'teacher_id' => Auth::id(),
        ]);

        return redirect()->route('assignments.index', $class)->with('success', 'Tugas berhasil dibuat!');
    }

    public function show(Assignment $assignment)
    {
        $user = Auth::user();
        $class = $assignment->class;
        
        // Check access
        if ($user->role === 'teacher' && $class->teacher_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke tugas ini.');
        }
        
        if ($user->role === 'student' && !$class->isEnrolledBy($user)) {
            abort(403, 'Anda tidak terdaftar di kelas ini.');
        }

        if ($user->role === 'student') {
            $submission = $assignment->getSubmissionByStudent($user->id);
            if (!$submission) {
                $submission = new Submission([
                    'assignment_id' => $assignment->id,
                    'student_id' => $user->id,
                ]);
            }
            $submissions = null;
        } else {
            $submission = null;
            $submissions = $assignment->submissions()->with('student')->get();
        }

        return view('assignments.show', compact('assignment', 'class', 'submission', 'submissions'));
    }

    public function submit(Request $request, Assignment $assignment)
    {
        if (!(Auth::user()->role === 'student')) {
            abort(403, 'Hanya siswa yang dapat mengumpulkan tugas.');
        }

        $user = Auth::user();
        $class = $assignment->class;

        if (!$class->isEnrolledBy($user)) {
            abort(403, 'Anda tidak terdaftar di kelas ini.');
        }

        if ($assignment->isOverdue()) {
            return back()->withErrors(['error' => 'Waktu pengumpulan tugas sudah berakhir.']);
        }

        $request->validate([
            'content' => 'nullable|string|max:10000',
            'file' => 'nullable|file|max:10240|mimes:pdf,doc,docx,txt,jpg,jpeg,png', // 10MB
        ]);

        if (!$request->content && !$request->hasFile('file')) {
            return back()->withErrors(['error' => 'Harap isi konten jawaban atau upload file.']);
        }

        $filePath = null;
        $originalFilename = null;
        if ($request->hasFile('file')) {
            // Delete old file if exists
            $existingSubmission = Submission::where([
                'assignment_id' => $assignment->id,
                'student_id' => $user->id,
            ])->first();
            
            if ($existingSubmission && $existingSubmission->file_path) {
                Storage::disk('public')->delete($existingSubmission->file_path);
            }
            
            $file = $request->file('file');
            $originalFilename = $file->getClientOriginalName();
            
            // Sanitize filename untuk keamanan
            $safeFilename = pathinfo($originalFilename, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $safeFilename = preg_replace('/[^A-Za-z0-9\-_.]/', '_', $safeFilename);
            
            // Generate unique filename dengan timestamp untuk menghindari konflik
            $filename = $safeFilename . '_' . time() . '.' . $extension;
            
            $filePath = $file->storeAs('submissions', $filename, 'public');
        }

        $submission = Submission::updateOrCreate(
            [
                'assignment_id' => $assignment->id,
                'student_id' => $user->id,
            ],
            [
                'content' => $request->content,
                'file_path' => $filePath,
                'original_filename' => $originalFilename,
                'submitted_at' => now(),
            ]
        );

        return redirect()->route('assignments.show', $assignment)->with('success', 'Tugas berhasil dikumpulkan!');
    }

    public function grade(Request $request, Assignment $assignment, Submission $submission)
    {
        if (!(Auth::user()->role === 'teacher') || $assignment->teacher_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk menilai tugas ini.');
        }

        $request->validate([
            'score' => 'required|integer|min:0|max:' . $assignment->max_score,
            'feedback' => 'nullable|string',
        ]);

        $submission->update([
            'score' => $request->score,
            'feedback' => $request->feedback,
        ]);

        return back()->with('success', 'Nilai berhasil diberikan!');
    }

    public function edit(Assignment $assignment)
    {
        if (!(Auth::user()->role === 'teacher') || $assignment->teacher_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit tugas ini.');
        }

        $class = $assignment->class;

        return view('assignments.edit', compact('assignment', 'class'));
    }

    public function update(Request $request, Assignment $assignment)
    {
        if (!(Auth::user()->role === 'teacher') || $assignment->teacher_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit tugas ini.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'max_score' => 'required|integer|min:1|max:1000',
        ]);

        $assignment->update([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'max_score' => $request->max_score,
        ]);

        return redirect()->route('assignments.show', $assignment)->with('success', 'Tugas berhasil diperbarui!');
    }

    public function destroy(Assignment $assignment)
    {
        if (!(Auth::user()->role === 'teacher') || $assignment->teacher_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus tugas ini.');
        }

        $class = $assignment->class;

        // Delete all submission files
        foreach ($assignment->submissions as $submission) {
            if ($submission->file_path) {
                Storage::disk('public')->delete($submission->file_path);
            }
        }

        $assignment->delete();

        return redirect()->route('assignments.index', $class)->with('success', 'Tugas berhasil dihapus!');
    }

    public function downloadSubmission(Submission $submission)
    {
        $user = Auth::user();
        $assignment = $submission->assignment;
        $class = $assignment->class;
        
        // Check access - teacher of the class or the student who submitted
        if ($user->role === 'teacher' && $class->teacher_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke submission ini.');
        }
        
        if ($user->role === 'student' && $submission->student_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke submission ini.');
        }

        if (!$submission->file_path || !Storage::disk('public')->exists($submission->file_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        $filename = $submission->original_filename ?? basename($submission->file_path);
        $filePath = storage_path('app/public/' . $submission->file_path);
        
        return response()->download($filePath, $filename);
    }
}

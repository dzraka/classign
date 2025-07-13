<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;
use App\Models\ClassModel;
use App\Models\Material;
use App\Models\ClassEnrollment;

class MaterialController extends Controller
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

        $materials = $class->materials()->orderBy('created_at', 'desc')->get();

        return view('materials.index', compact('class', 'materials'));
    }

    public function create(Request $request)
    {
        if (Auth::user()->role !== 'teacher') {
            abort(403, 'Hanya pengajar yang dapat membuat materi.');
        }

        $classId = $request->get('class_id');
        $class = ClassModel::findOrFail($classId);

        if ($class->teacher_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk membuat materi di kelas ini.');
        }

        return view('materials.create', compact('class'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'teacher') {
            abort(403, 'Hanya pengajar yang dapat membuat materi.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'class_id' => 'required|exists:classes,id',
            'file' => 'nullable|file|max:10240', // 10MB
        ]);

        $class = ClassModel::findOrFail($request->class_id);

        if ($class->teacher_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk membuat materi di kelas ini.');
        }

        $filePath = null;
        $originalFilename = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalFilename = $file->getClientOriginalName();
            
            // Sanitize filename untuk keamanan
            $safeFilename = pathinfo($originalFilename, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $safeFilename = preg_replace('/[^A-Za-z0-9\-_.]/', '_', $safeFilename);
            
            // Generate unique filename dengan timestamp untuk menghindari konflik
            $filename = $safeFilename . '_' . time() . '.' . $extension;
            
            $filePath = $file->storeAs('materials', $filename, 'public');
        }

        $material = Material::create([
            'title' => $request->title,
            'content' => $request->content,
            'file_path' => $filePath,
            'original_filename' => $originalFilename,
            'class_id' => $request->class_id,
            'teacher_id' => Auth::id(),
        ]);

        return redirect()->route('materials.index', $class)->with('success', 'Materi berhasil dibuat!');
    }

    public function show(Material $material)
    {
        $user = Auth::user();
        $class = $material->class;
        
        // Check access
        if ($user->role === 'teacher' && $class->teacher_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke materi ini.');
        }
        
        if ($user->role === 'student' && !$class->isEnrolledBy($user)) {
            abort(403, 'Anda tidak terdaftar di kelas ini.');
        }

        return view('materials.show', compact('material', 'class'));
    }

    public function edit(Material $material)
    {
        if (Auth::user()->role !== 'teacher' || $material->teacher_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit materi ini.');
        }

        $class = $material->class;

        return view('materials.edit', compact('material', 'class'));
    }

    public function update(Request $request, Material $material)
    {
        if (Auth::user()->role !== 'teacher' || $material->teacher_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit materi ini.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'file' => 'nullable|file|max:10240', // 10MB
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
        ];

        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }
            
            $file = $request->file('file');
            $originalFilename = $file->getClientOriginalName();
            
            // Sanitize filename untuk keamanan
            $safeFilename = pathinfo($originalFilename, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $safeFilename = preg_replace('/[^A-Za-z0-9\-_.]/', '_', $safeFilename);
            
            // Generate unique filename dengan timestamp untuk menghindari konflik
            $filename = $safeFilename . '_' . time() . '.' . $extension;
            
            $data['file_path'] = $file->storeAs('materials', $filename, 'public');
            $data['original_filename'] = $originalFilename;
        }

        $material->update($data);

        return redirect()->route('materials.show', $material)->with('success', 'Materi berhasil diperbarui!');
    }

    public function destroy(Material $material)
    {
        if (Auth::user()->role !== 'teacher' || $material->teacher_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus materi ini.');
        }

        $class = $material->class;

        // Delete file if exists
        if ($material->file_path) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();

        return redirect()->route('materials.index', $class)->with('success', 'Materi berhasil dihapus!');
    }

    public function download(Material $material)
    {
        $user = Auth::user();
        $class = $material->class;
        
        // Check access
        if ($user->role === 'teacher' && $class->teacher_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke materi ini.');
        }
        
        if ($user->role === 'student' && !$class->isEnrolledBy($user)) {
            abort(403, 'Anda tidak terdaftar di kelas ini.');
        }

        // Periksa keberadaan file
        if (!$material->file_path) {
            abort(404, 'File tidak ditemukan. File path kosong.');
        }
        
        if (!Storage::disk('public')->exists($material->file_path)) {
            abort(404, 'File tidak ditemukan di storage.');
        }

        $filename = $material->original_filename ?? basename($material->file_path);
        $filePath = storage_path('app/public/' . $material->file_path);
        
        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan di path: ' . $filePath);
        }
        
        return response()->download($filePath, $filename);
    }
}

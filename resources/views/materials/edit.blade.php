@extends('layouts.app')

@section('title', 'Edit Materi - ' . $material->title)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10 col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header text-white" style="background-color: #050d1c;">
                <h5 class="mb-0">
                    <i class="bi bi-pencil me-2"></i>Edit Materi
                </h5>
                <small class="text-white">{{ $material->title }} - {{ $class->name }}</small>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('materials.update', $material) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Materi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $material->title) }}" required>
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Konten Materi <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" name="content" rows="10" required>{{ old('content', $material->content) }}</textarea>
                        @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @if($material->file_path)
                    <div class="mb-3">
                        <label class="form-label">File Saat Ini</label>
                        <div class="d-flex align-items-center bg-light p-3 rounded">
                            <i class="bi bi-file-earmark-text text-black me-3" style="font-size: 2rem;"></i>
                            <div class="flex-grow-1">
                                <strong>{{ basename($material->file_path) }}</strong>
                            </div>
                            <a href="{{ asset('storage/' . $material->file_path) }}" class="btn btn-outline-success" download>
                                <i class="bi bi-download me-1"></i>Unduh
                            </a>
                        </div>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label for="file" class="form-label">
                            {{ $material->file_path ? 'Ganti File (Opsional)' : 'Lampiran File (Opsional)' }}
                        </label>
                        <input type="file" class="form-control @error('file') is-invalid @enderror" 
                               id="file" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx,.txt">
                        @error('file')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            File yang diizinkan: PDF, DOC, DOCX, PPT, PPTX, TXT. Maksimal 10MB.
                            @if($material->file_path)
                            File baru akan menggantikan file yang lama.
                            @endif
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-dark">
                            <i class="bi bi-check me-2"></i>Simpan Perubahan
                        </button>
                        <a href="{{ route('materials.show', $material) }}" class="btn btn-danger">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
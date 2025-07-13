@extends('layouts.app')

@section('title', 'Tambah Materi - ' . $class->name)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10 col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header text-white" style="background-color: #050d1c;">
                <h5 class="mb-0">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Materi Baru
                </h5>
                <small class="text-white ">Kelas: {{ $class->name }}</small>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('materials.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="class_id" value="{{ $class->id }}">
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Materi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Konten Materi <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" name="content" rows="10" required>{{ old('content') }}</textarea>
                        @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Konten utama materi yang akan dibaca siswa</div>
                    </div>

                    <div class="mb-3">
                        <label for="file" class="form-label">Lampiran File (Opsional)</label>
                        <input type="file" class="form-control @error('file') is-invalid @enderror" 
                               id="file" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx,.txt">
                        @error('file')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            File yang diizinkan: PDF, DOC, DOCX, PPT, PPTX, TXT. Maksimal 10MB.
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-dark">
                            <i class="bi bi-check me-2"></i>Simpan Materi
                        </button>
                        <a href="{{ route('materials.index', $class) }}" class="btn btn-danger">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
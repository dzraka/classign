@extends('layouts.app')

@section('title', 'Buat Kelas Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow">
            <div class="card-header text-white" style="background-color: #050d1c;">
                <h5 class="mb-0">
                    <i class="bi bi-plus-circle me-2"></i>Buat Kelas Baru
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('classes.store') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Kelas <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi Kelas <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4" required
                                  placeholder="Berikan deskripsi singkat tentang kelas ini...">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Deskripsi akan membantu siswa memahami tentang kelas ini.</div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-dark">
                            <i class="bi bi-check me-2"></i>Buat Kelas
                        </button>
                        <a href="{{ route('classes.index') }}" class="btn btn-danger">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Edit Kelas - ' . $class->name)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card">
            <div class="card-header text-white" style="background-color: #050d1c;">
                <h5 class="mb-0">
                    <i class="bi bi-pencil me-2"></i>Edit Kelas
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('classes.update', $class) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Kelas <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $class->name) }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi Kelas</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4">{{ old('description', $class->description) }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="class_code" class="form-label">Kode Kelas</label>
                        <input type="text" class="form-control" value="{{ $class->class_code }}" readonly>
                        <div class="form-text">Kode kelas tidak dapat diubah</div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-dark">
                            <i class="bi bi-check me-2"></i>Simpan Perubahan
                        </button>
                        <a href="{{ route('classes.show', $class) }}" class="btn btn-danger">Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

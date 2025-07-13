@extends('layouts.app')

@section('title', 'Gabung Kelas')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card">
            <div class="card-header text-white" style="background-color: #050d1c;">
                <h5 class="mb-0">
                    <i class="bi bi-plus-circle me-2"></i>Gabung Kelas
                </h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <i class="bi bi-people text-dark" style="font-size: 3rem;"></i>
                    <p class="mt-2 text-muted">Masukkan kode kelas yang diberikan oleh pengajar untuk bergabung</p>
                </div>

                <form method="POST" action="{{ route('classes.join.store') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="class_code" class="form-label">Kode Kelas <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('class_code') is-invalid @enderror text-center" 
                               id="class_code" name="class_code" value="{{ old('class_code') }}" required
                               placeholder="Contoh: ABC123" maxlength="6" minlength="6" style="font-size: 1.5rem; letter-spacing: 0.2em;">
                        @error('class_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Kode kelas terdiri dari 6 karakter alfanumerik</div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-dark flex-fill">
                            <i class="bi bi-check me-2"></i>Gabung Kelas
                        </button>
                        <a href="{{ route('classes.index') }}" class="btn btn-danger">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Instructions -->
        <div class="card mt-4">
            <div class="card-header text-white" style="background-color: #050d1c;">
                <h6 class="mb-0">
                    <i class="bi bi-question-circle me-2"></i>Cara Bergabung Kelas
                </h6>
            </div>
            <div class="card-body">
                <ol class="mb-0">
                    <li>Dapatkan kode kelas dari pengajar Anda</li>
                    <li>Masukkan kode kelas pada form di atas</li>
                    <li>Klik tombol "Gabung Kelas"</li>
                    <li>Anda akan langsung terdaftar di kelas tersebut</li>
                </ol>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
document.getElementById('class_code').addEventListener('input', function(e) {
    e.target.value = e.target.value.toUpperCase();
});
</script>
@endsection
@endsection

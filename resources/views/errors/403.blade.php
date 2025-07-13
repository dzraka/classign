@extends('layouts.app')

@section('title', 'Akses Ditolak')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="text-center">
            <div class="mb-4">
                <i class="bi bi-shield-exclamation text-danger" style="font-size: 5rem;"></i>
            </div>
            <h2 class="mb-3">Akses Ditolak</h2>
            <p class="text-muted mb-4">
                Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.
            </p>
            <div class="d-flex gap-2 justify-content-center">
                <a href="{{ route('dashboard') }}" class="btn btn-dark">
                    <i class="bi bi-house me-2"></i>Kembali ke Beranda
                </a>
                <button onclick="history.back()" class="btn btn-outline-dark">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

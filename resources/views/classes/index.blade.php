@extends('layouts.app')

@section('title', 'Daftar Kelas')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Daftar Kelas</h1>
                <p class="text-muted mb-0">
                    @if(Auth::user()->role === 'teacher')
                        Kelola kelas yang Anda ajar
                    @else
                        Kelas yang Anda ikuti
                    @endif
                </p>
            </div>
            <div>
                @if(Auth::user()->role === 'teacher')
                <a href="{{ route('classes.create') }}" class="btn btn-dark">
                    <i class="bi bi-plus-circle me-2"></i>Buat Kelas
                </a>
                @else
                <a href="{{ route('classes.join') }}" class="btn btn-dark">
                    <i class="bi bi-plus-circle me-2"></i>Gabung Kelas
                </a>
                @endif
            </div>
        </div>
    </div>
</div>

@if($classes->count() > 0)
<div class="row">
    @foreach($classes as $class)
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card card-hover h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h5 class="card-title mb-0">{{ $class->name }}</h5>
                    @if(Auth::user()->role === 'teacher')
                    <div class="dropstart">
                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('classes.edit', $class) }}">
                                <i class="bi bi-pencil me-2"></i>Edit
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('classes.destroy', $class) }}" 
                                      onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-trash me-2"></i>Hapus
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    @endif
                </div>
                
                <p class="card-text text-muted">
                    {{ Str::limit($class->description, 45) ?: 'Tidak ada deskripsi' }}
                </p>
                
                @if(Auth::user()->role === 'teacher')
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <div class="bg-light p-2 rounded text-center">
                            <small class="text-muted d-block">Siswa</small>
                            <strong>{{ $class->students_count }}</strong>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-light p-2 rounded text-center">
                            <small class="text-muted d-block">Kode</small>
                            <strong>{{ $class->class_code }}</strong>
                        </div>
                    </div>
                </div>
                @endif
                
                @if(Auth::user()->role === 'student')
                <div class="mb-3">
                    <small class="fw-semibold">Pengajar: {{ $class->teacher->display_name }}</small>
                </div>
                @endif
                
                <div class="d-flex gap-2">
                    <a href="{{ route('classes.show', $class) }}" class="btn btn-dark">
                        Lihat Kelas
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="text-center py-5">
    <i class="bi bi-journal-x text-muted" style="font-size: 4rem;"></i>
    <h3 class="mt-3 text-muted">
        @if(Auth::user()->role === 'teacher')
            Belum ada kelas yang dibuat
        @else
            Belum mengikuti kelas apapun
        @endif
    </h3>
    <p class="text-muted">
        @if(Auth::user()->role === 'teacher')
            Mulai dengan membuat kelas pertama Anda untuk mengajar siswa
        @else
            Bergabung dengan kelas menggunakan kode kelas dari pengajar
        @endif
    </p>
    @if(Auth::user()->role === 'teacher')
    <a href="{{ route('classes.create') }}" class="btn btn-outline-dark btn-lg">
        <i class="bi bi-plus-circle me-2"></i>Buat Kelas Pertama
    </a>
    @else
    <a href="{{ route('classes.join') }}" class="btn btn-outline-dark btn-lg">
        <i class="bi bi-plus-circle me-2"></i>Gabung Kelas
    </a>
    @endif
</div>
@endif
@endsection

@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Beranda</h1>
                <p class="text-muted mb-0">Selamat datang kembali, {{ Auth::user()->display_name }}!</p>
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

<div class="row">
    <div class="col mb-4">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center text-white" style="background-color: #050d1c;">
                <h5 class="mb-0">
                    <i class="bi bi-clock me-2"></i>Tugas Mendatang
                </h5>
                <a href="{{ route('calendar') }}" class="btn btn-sm btn-outline-light">Lihat Semua</a>
            </div>
            <div class="card-body">
                @if($upcomingAssignments->count() > 0)
                    @foreach($upcomingAssignments->take(5) as $assignment)
                    <div class="assignment-card card mb-2 {{ $assignment->getDaysLeft() <= 2 ? 'assignment-due-soon' : '' }}">
                        <div class="card-body p-3">
                            <h6 class="card-title mb-1">{{ $assignment->title }}</h6>
                            <p class="card-text small text-muted mb-2">{{ $assignment->class->name }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="bi bi-calendar me-1"></i>
                                    {{ $assignment->due_date->format('d M, H:i') }}
                                </small>
                                <span class="badge {{ $assignment->getDaysLeft() <= 2 ? 'bg-warning' : 'bg-primary' }}">
                                    {{ $assignment->getTimeLeft() }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="text-center py-4">
                        <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                        <p class="mt-2 mb-0 text-muted">Tidak ada tugas mendatang</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col mb-4">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center text-white" style="background-color: #050d1c;">
                <h5 class="mb-0">
                    <i class="bi bi-journal-bookmark me-2"></i>
                    @if(Auth::user()->role === 'teacher')
                        Kelas yang Anda Ajar
                    @else
                        Kelas yang Anda Ikuti
                    @endif
                </h5>
                <a href="{{ route('classes.index') }}" class="btn btn-sm btn-outline-light">Lihat Semua</a>
            </div>
            <div class="card-body">
                @if($classes->count() > 0)
                <div class="row">
                    @foreach($classes->take(6) as $class)
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card card-hover h-100">
                            <div class="card-body">
                                <h6 class="card-title">{{ $class->name }}</h6>
                                <p class="card-text text-muted small">
                                    {{ Str::limit($class->description, 50) }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="bi bi-people me-1"></i>{{ $class->students_count }} siswa
                                    </small>
                                    <a href="{{ route('classes.show', $class) }}" class="btn btn-dark">Lihat</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-4">
                    <i class="bi bi-journal-x text-muted" style="font-size: 3rem;"></i>
                    <h5 class="mt-3 text-muted">
                        @if(Auth::user()->role === 'teacher')
                            Belum ada kelas yang dibuat
                        @else
                            Belum mengikuti kelas apapun
                        @endif
                    </h5>
                    <p class="text-muted">
                        @if(Auth::user()->role === 'teacher')
                            Mulai dengan membuat kelas pertama Anda
                        @else
                            Bergabung dengan kelas menggunakan kode kelas
                        @endif
                    </p>
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
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('title', $class->name)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('classes.index') }}">Kelas</a></li>
                        <li class="breadcrumb-item active">{{ $class->name }}</li>
                    </ol>
                </nav>
                <h1 class="h3 mb-0">{{ $class->name }}</h1>
                <p class="text-muted mb-0">{{ $class->description ?: 'Tidak ada deskripsi' }}</p>
            </div>
            <div>
                @if(Auth::user()->role === 'teacher' && $class->teacher_id === Auth::id())
                <div class="btn-group" role="group">
                    <a href="{{ route('classes.edit', $class) }}" class="btn btn-outline-dark">
                        <i class="bi bi-pencil me-1"></i>Edit
                    </a>
                    <button type="button" class="btn btn-dark dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">
                        <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('materials.create', ['class_id' => $class->id]) }}">
                            <i class="bi bi-journal-plus me-2"></i>Tambah Materi
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('assignments.create', ['class_id' => $class->id]) }}">
                            <i class="bi bi-clipboard-plus me-2"></i>Tambah Tugas
                        </a></li>
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if(Auth::user()->role === 'teacher' && $class->teacher_id === Auth::id())
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card shadow-sm text-white" style="background-color: #050d1c">
            <div class="card-body text-center">
                <i class="bi bi-key-fill" style="font-size: 2rem;"></i>
                <h4 class="mt-2">{{ $class->class_code }}</h4>
                <p class="mb-0">Kode Kelas</p>
            </div>
        </div>
    </div>
</div>
@endif

<div class="row">
    <div class="col-12 mb-4">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center text-white" style="background-color: #050d1c">
                <h5 class="mb-0">
                    <i class="bi bi-journal-text me-2"></i>Materi Terbaru
                </h5>
                <a href="{{ route('materials.index', $class) }}" class="btn btn-sm btn-outline-light">Lihat Semua</a>
            </div>
            <div class="card-body">
                @if($class->materials->count() > 0)
                @foreach($class->materials->take(3) as $material)
                <div class="d-flex align-items-start mb-3">
                    <div class="flex-shrink-0">
                        <div class="bg-dark text-white rounded d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-file-text"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-1">
                            <a href="{{ route('materials.show', $material) }}" class="text-decoration-none fw-bold text-black">
                                {{ $material->title }}
                            </a>
                        </h6>
                        <p class="text-muted small mb-1">{{ Str::limit($material->content, 80) }}</p>
                        <small class="text-muted">{{ $material->created_at->diffForHumans() }}</small>
                    </div>
                </div>
                @if(!$loop->last)<hr>@endif
                @endforeach
                @else
                <div class="text-center py-3">
                    <i class="bi bi-journal-x text-muted" style="font-size: 2rem;"></i>
                    <p class="mt-2 mb-0 text-muted">Belum ada materi</p>
                    @if(Auth::user()->role === 'teacher' && $class->teacher_id === Auth::id())
                    <a href="{{ route('materials.create', ['class_id' => $class->id]) }}" class="btn btn-sm btn-dark mt-2">
                        <i class="bi bi-plus-circle me-1"></i>Tambah Materi
                    </a>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-12 mb-4">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center text-white" style="background-color: #050d1c">
                <h5 class="mb-0">
                    <i class="bi bi-clipboard-check me-2"></i>Tugas Terbaru
                </h5>
                <a href="{{ route('assignments.index', $class) }}" class="btn btn-sm btn-outline-light">Lihat Semua</a>
            </div>
            <div class="card-body">
                @if($class->assignments->count() > 0)
                @foreach($class->assignments->take(3) as $assignment)
                <div class="d-flex align-items-start mb-3">
                    <div class="flex-shrink-0">
                        <div class="bg-dark text-white rounded d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-clipboard"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-1">
                            <a href="{{ route('assignments.show', $assignment) }}" class="text-decoration-none fw-bold text-black">
                                {{ $assignment->title }}
                            </a>
                        </h6>
                        <p class="text-muted small mb-1">{{ Str::limit($assignment->description, 80) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">Deadline: {{ $assignment->due_date->format('d M Y, H:i') }}</small>
                            <span class="badge {{ $assignment->isOverdue() ? 'bg-danger' : 'bg-success' }}">
                                {{ $assignment->getTimeLeft() }}
                            </span>
                        </div>
                    </div>
                </div>
                @if(!$loop->last)<hr>@endif
                @endforeach
                @else
                <div class="text-center py-3">
                    <i class="bi bi-clipboard-x text-muted" style="font-size: 2rem;"></i>
                    <p class="mt-2 mb-0 text-muted">Belum ada tugas</p>
                    @if(Auth::user()->role === 'teacher' && $class->teacher_id === Auth::id())
                    <a href="{{ route('assignments.create', ['class_id' => $class->id]) }}" class="btn btn-sm btn-dark mt-2">
                        <i class="bi bi-plus-circle me-1"></i>Tambah Tugas
                    </a>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@if(Auth::user()->role === 'teacher' && $class->teacher_id === Auth::id())
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header text-white" style="background-color: #050d1c;">
                <h5 class="mb-0">
                    <i class="bi bi-people me-2"></i>Daftar Siswa
                </h5>
            </div>
            <div class="card-body">
                @if($class->students->count() > 0)
                <div class="row">
                    @foreach($class->students as $student)
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">{{ $student->display_name }}</h6>
                                <small class="text-muted">{{ $student->email }}</small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-3">
                    <i class="bi bi-people text-muted" style="font-size: 2rem;"></i>
                    <p class="mt-2 mb-0 text-muted">Belum ada siswa yang bergabung</p>
                    <p class="small text-muted">Bagikan kode kelas <strong>{{ $class->class_code }}</strong> kepada siswa</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endif
@endsection

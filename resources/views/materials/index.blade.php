@extends('layouts.app')

@section('title', 'Materi - ' . $class->name)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('classes.index') }}">Kelas</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('classes.show', $class) }}">{{ $class->name }}</a></li>
                        <li class="breadcrumb-item active">Materi</li>
                    </ol>
                </nav>
                <h1 class="h3 mb-0">Materi Kelas</h1>
                <p class="text-muted mb-0">{{ $class->name }}</p>
            </div>
            <div>
                @if(Auth::user()->role === 'teacher' && $class->teacher_id === Auth::id())
                <a href="{{ route('materials.create', ['class_id' => $class->id]) }}" class="btn btn-dark">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Materi
                </a>
                @endif
            </div>
        </div>
    </div>
</div>

@if($materials->count() > 0)
<div class="row">
    @foreach($materials as $material)
    <div class="col-12 mb-4">
        <div class="card card-hover">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="flex-grow-1">
                        <h5 class="card-title mb-2">
                            <a href="{{ route('materials.show', $material) }}" class="text-decoration-none text-black fw-bold">
                                {{ $material->title }}
                            </a>
                        </h5>
                        <p class="card-text text-muted">
                            {{ Str::limit($material->content, 200) }}
                        </p>
                    </div>
                    @if(Auth::user()->role === 'teacher' && $material->teacher_id === Auth::id())
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-dark" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('materials.edit', $material) }}">
                                <i class="bi bi-pencil me-2"></i>Edit
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('materials.destroy', $material) }}" 
                                      onsubmit="return confirm('Yakin ingin menghapus materi ini?')">
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
                
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        @if($material->file_path)
                        <span class="badge bg-info me-2">
                            <i class="bi bi-paperclip me-1"></i>Lampiran
                        </span>
                        @endif
                        <small class="text-muted">
                            <i class="bi bi-calendar me-1"></i>
                            {{ $material->created_at->format('d M Y, H:i') }}
                        </small>
                        <small class="text-muted ms-3">
                            <i class="bi bi-person me-1"></i>
                            {{ $material->teacher->display_name }}
                        </small>
                    </div>
                    <a href="{{ route('materials.show', $material) }}" class="btn btn-dark">
                        Lihat Materi
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
    <h3 class="mt-3 text-muted">Belum ada materi</h3>
    <p class="text-muted">
        @if(Auth::user()->role === 'teacher' && $class->teacher_id === Auth::id())
            Mulai dengan menambahkan materi pertama untuk kelas ini
        @else
            Materi akan muncul di sini ketika pengajar menambahkannya
        @endif
    </p>
    @if(Auth::user()->role === 'teacher' && $class->teacher_id === Auth::id())
    <a href="{{ route('materials.create', ['class_id' => $class->id]) }}" class="btn btn-dark btn-lg">
        <i class="bi bi-plus-circle me-2"></i>Tambah Materi Pertama
    </a>
    @endif
</div>
@endif
@endsection
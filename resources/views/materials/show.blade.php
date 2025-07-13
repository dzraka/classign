@extends('layouts.app')

@section('title', $material->title)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10 col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header text-white" style="background-color: #050d1c;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="mb-0">{{ $material->title }}</h5>
                        <small class="text-white">{{ $class->name }}</small>
                    </div>
                    @if(Auth::user()->role === 'teacher' && $material->teacher_id === Auth::id())
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-light" type="button" data-bs-toggle="dropdown">
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
            </div>
            <div class="card-body">
                <!-- Material Info -->
                <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-light rounded">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="bi bi-person-fill"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">{{ $material->teacher->display_name }}</h6>
                            <small class="text-muted">Pengajar</small>
                        </div>
                    </div>
                    <div class="text-end">
                        <small class="text-muted">
                            <i class="bi bi-calendar me-1"></i>
                            {{ $material->created_at->format('d M Y, H:i') }}
                        </small>
                        @if($material->updated_at != $material->created_at)
                        <br>
                        <small class="text-muted">
                            <i class="bi bi-pencil me-1"></i>
                            Diperbarui {{ $material->updated_at->diffForHumans() }}
                        </small>
                        @endif
                    </div>
                </div>

                <!-- Material Content -->
                <div class="material-content">
                    <div class="mb-4">
                        {!! nl2br(e($material->content)) !!}
                    </div>

                    <!-- File Attachment -->
                    @if($material->file_path)
                    <div class="card bg-light border-0">
                        <div class="card-body">
                            <h6 class="card-title">
                                <i class="bi bi-paperclip me-2"></i>Lampiran File
                            </h6>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-file-earmark-text text-secondary" style="font-size: 2rem;"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">{{ $material->original_filename ?? basename($material->file_path) }}</h6>
                                    <small class="text-muted">Klik untuk mengunduh</small>
                                </div>
                                <div>
                                    <a href="{{ route('materials.download', $material) }}" class="btn btn-outline-success">
                                        <i class="bi bi-download me-2"></i>Unduh
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex gap-2">
                    <a href="{{ route('materials.index', $class) }}" class="btn btn-danger">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<style>
.material-content {
    line-height: 1.8;
    font-size: 1.1rem;
}
.material-content p {
    margin-bottom: 1rem;
}
</style>
@endsection
@endsection

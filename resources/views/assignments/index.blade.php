@extends('layouts.app')

@section('title', 'Tugas - ' . $class->name)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('classes.index') }}">Kelas</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('classes.show', $class) }}">{{ $class->name }}</a></li>
                        <li class="breadcrumb-item active">Tugas</li>
                    </ol>
                </nav>
                <h1 class="h3 mb-0">Daftar Tugas</h1>
                <p class="text-muted mb-0">{{ $class->name }}</p>
            </div>
            <div>
                @if(Auth::user()->role === 'teacher' && $class->teacher_id === Auth::id())
                <a href="{{ route('assignments.create', ['class_id' => $class->id]) }}" class="btn btn-dark">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Tugas
                </a>
                @endif
            </div>
        </div>
    </div>
</div>

@if(Auth::user()->role === 'student')
<!-- Filter untuk siswa -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body py-2">
                <div class="d-flex align-items-center">
                    <small class="text-muted me-3">Filter:</small>
                    <div class="btn-group btn-group-sm" role="group">
                        <input type="radio" class="btn-check" name="filter" id="all" value="all" checked>
                        <label class="btn btn-outline-dark" for="all">Semua</label>
                        
                        <input type="radio" class="btn-check" name="filter" id="pending" value="pending">
                        <label class="btn btn-outline-warning" for="pending">Belum Dikumpul</label>
                        
                        <input type="radio" class="btn-check" name="filter" id="submitted" value="submitted">
                        <label class="btn btn-outline-success" for="submitted">Sudah Dikumpul</label>
                        
                        <input type="radio" class="btn-check" name="filter" id="overdue" value="overdue">
                        <label class="btn btn-outline-danger" for="overdue">Terlambat</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if($assignments->count() > 0)
<div class="row" id="assignments-list">
    @foreach($assignments as $assignment)
    <div class="col-12 mb-4">
        <div class="card assignment-card {{ $assignment->isOverdue() ? 'assignment-overdue' : ($assignment->getDaysLeft() <= 2 ? 'assignment-due-soon' : '') }}">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="flex-grow-1">
                        <h5 class="card-title mb-2">
                            <a href="{{ route('assignments.show', $assignment) }}" class="text-decoration-none text-black fw-bold">
                                {{ $assignment->title }}
                            </a>
                        </h5>
                        <p class="card-text text-muted">
                            {{ Str::limit($assignment->description, 200) }}
                        </p>
                    </div>
                    @if(Auth::user()->role === 'teacher' && $assignment->teacher_id === Auth::id())
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-dark" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('assignments.edit', $assignment) }}">
                                <i class="bi bi-pencil me-2"></i>Edit
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('assignments.destroy', $assignment) }}" 
                                      onsubmit="return confirm('Yakin ingin menghapus tugas ini?')">
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
                
                <div class="row g-3 mb-3">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-calendar text-muted me-2"></i>
                            <div>
                                <small class="text-muted d-block">Deadline</small>
                                <strong>{{ $assignment->due_date->format('d M Y, H:i') }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-star text-muted me-2"></i>
                            <div>
                                <small class="text-muted d-block">Nilai Max</small>
                                <strong>{{ $assignment->max_score }}</strong>
                            </div>
                        </div>
                    </div>
                    @if(Auth::user()->role === 'teacher')
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-people text-muted me-2"></i>
                            <div>
                                <small class="text-muted d-block">Dikumpulkan</small>
                                <strong>{{ $assignment->getSubmissionCount() }} / {{ $class->students->count() }}</strong>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle text-muted me-2"></i>
                            <div>
                                <small class="text-muted d-block">Status</small>
                                @if(isset($assignment->user_submission) && $assignment->user_submission)
                                <span class="badge bg-success">{{ $assignment->user_submission->status }}</span>
                                @else
                                <span class="badge bg-warning">Belum Dikumpulkan</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-clock text-muted me-2"></i>
                            <div>
                                <small class="text-muted d-block">Waktu Tersisa</small>
                                @if($assignment->isOverdue())
                                <span class="badge bg-danger">Terlambat</span>
                                @else
                                <span class="badge bg-{{ $assignment->getDaysLeft() <= 2 ? 'warning' : 'primary' }}">
                                    {{ $assignment->getTimeLeft() }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        <i class="bi bi-person me-1"></i>
                        {{ $assignment->teacher->display_name }}
                    </small>
                    <a href="{{ route('assignments.show', $assignment) }}" class="btn btn-dark">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="text-center py-5" id="empty-state">
    <i class="bi bi-clipboard-x text-muted" style="font-size: 4rem;"></i>
    <h3 class="mt-3 text-muted">Belum ada tugas</h3>
    <p class="text-muted">
        @if(Auth::user()->role === 'teacher' && $class->teacher_id === Auth::id())
            Mulai dengan menambahkan tugas pertama untuk kelas ini
        @else
            Tugas akan muncul di sini ketika pengajar menambahkannya
        @endif
    </p>
    @if(Auth::user()->role === 'teacher' && $class->teacher_id === Auth::id())
    <a href="{{ route('assignments.create', ['class_id' => $class->id]) }}" class="btn btn-dark btn-lg">
        <i class="bi bi-plus-circle me-2"></i>Tambah Tugas Pertama
    </a>
    @endif
</div>

<!-- Empty state for filtered results -->
<div class="text-center py-5" id="filter-empty-state" style="display: none;">
    <i class="bi bi-funnel text-muted" style="font-size: 4rem;"></i>
    <h3 class="mt-3 text-muted">Tidak ada tugas</h3>
    <p class="text-muted">Tidak ada tugas yang sesuai dengan filter yang dipilih</p>
</div>
@endif
@endsection

@section('scripts')
<script>
// Filter functionality for students
document.addEventListener('DOMContentLoaded', function() {
    const filterRadios = document.querySelectorAll('input[name="filter"]');
    const assignmentCards = document.querySelectorAll('.assignment-card');
    
    filterRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            const filterValue = this.value;
            
            assignmentCards.forEach(card => {
                const isOverdue = card.classList.contains('assignment-overdue');
                const statusBadge = card.querySelector('.badge');
                let isSubmitted = false;
                
                if (statusBadge) {
                    isSubmitted = statusBadge.textContent.includes('Dikumpulkan') || 
                                 statusBadge.textContent.includes('Dinilai');
                }
                
                let shouldShow = true;
                
                switch(filterValue) {
                    case 'pending':
                        shouldShow = !isSubmitted && !isOverdue;
                        break;
                    case 'submitted':
                        shouldShow = isSubmitted;
                        break;
                    case 'overdue':
                        shouldShow = isOverdue && !isSubmitted;
                        break;
                    case 'all':
                    default:
                        shouldShow = true;
                        break;
                }
                
                if (shouldShow) {
                    card.closest('.col-12').style.display = 'block';
                } else {
                    card.closest('.col-12').style.display = 'none';
                }
            });
            
            // Update empty state
            updateEmptyState();
        });
    });
    
    function updateEmptyState() {
        const visibleCards = Array.from(assignmentCards).filter(card => 
            card.closest('.col-12').style.display !== 'none'
        );
        
        const filterEmptyState = document.getElementById('filter-empty-state');
        const assignmentsList = document.getElementById('assignments-list');
        
        if (visibleCards.length === 0 && assignmentCards.length > 0) {
            if (filterEmptyState) filterEmptyState.style.display = 'block';
            if (assignmentsList) assignmentsList.style.display = 'none';
        } else {
            if (filterEmptyState) filterEmptyState.style.display = 'none';
            if (assignmentsList) assignmentsList.style.display = 'block';
        }
    }
});
</script>
@endsection

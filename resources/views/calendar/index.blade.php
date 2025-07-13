@extends('layouts.app')

@section('title', 'Kalender Tugas')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Kalender Tugas</h1>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        Minggu {{ $startOfWeek->format('d M') }} - {{ $endOfWeek->format('d M Y') }}
                    </h5>
                    <div class="btn-group gap-3" role="group">
                        <a href="{{ route('calendar') }}?week={{ $startOfWeek->copy()->subWeek()->format('Y-m-d') }}" class="btn btn-outline-dark">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                        <a href="{{ route('calendar') }}?week={{ $startOfWeek->copy()->addWeek()->format('Y-m-d') }}" class="btn btn-outline-dark">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    @foreach($weeklyAssignments as $dayData)
    <div class="col-lg mb-3">
        <div class="card shadow-sm h-100">
            <div class="card-header text-center {{ $dayData['date']->isToday() ? 'bg-primary' : 'text-white' }}" style="{{ !$dayData['date']->isToday() ? 'background-color: #050d1c' : 'color: white;' }}">
                <h6 class="mb-0">
                    @switch($dayData['date']->format('l'))
                        @case('Monday') Senin @break
                        @case('Tuesday') Selasa @break
                        @case('Wednesday') Rabu @break
                        @case('Thursday') Kamis @break
                        @case('Friday') Jumat @break
                        @case('Saturday') Sabtu @break
                        @case('Sunday') Minggu @break
                        @default {{ $dayData['date']->format('l') }}
                    @endswitch
                </h6>
                <small>{{ $dayData['date']->format('d M') }}</small>
                {{-- @if($dayData['date']->isToday())
                    <small class="d-block">Hari Ini</small>
                @endif --}}
            </div>
            <div class="card-body calendar-day p-2">
                @if($dayData['assignments']->count() > 0)
                @foreach($dayData['assignments'] as $assignment)
                <div class="assignment-item bg-{{ $assignment->isOverdue() ? 'danger' : ($assignment->getDaysLeft() <= 2 ? 'warning' : 'primary') }} text-white rounded mb-1">
                    <div class="fw-bold">{{ $assignment->title }}</div>
                    <div class="small">{{ $assignment->class->name }}</div>
                    <div class="small">{{ $assignment->due_date->format('H:i') }}</div>
                    <a href="{{ route('assignments.show', $assignment) }}" class="stretched-link"></a>
                </div>
                @endforeach
                @else
                <div class="text-center text-muted py-3">
                    <i class="bi bi-calendar-x"></i>
                    <div class="small">Tidak ada tugas</div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Legend -->
<div class="row mt-3">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="mb-3">Keterangan:</h6>
                <div class="d-flex flex-wrap gap-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary rounded me-2" style="width: 20px; height: 20px;"></div>
                        <small>Tugas Normal</small>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="bg-warning rounded me-2" style="width: 20px; height: 20px;"></div>
                        <small>Deadline Dekat (≤2 hari)</small>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="bg-danger rounded me-2" style="width: 20px; height: 20px;"></div>
                        <small>Terlambat</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
setTimeout(function() {
    location.reload();
}, 300000);
</script>
@endsection

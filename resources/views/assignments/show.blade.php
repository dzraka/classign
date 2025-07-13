@extends('layouts.app')

@section('title', $assignment->title)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10 col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header text-white" style="background-color: #050d1c;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="mb-0">{{ $assignment->title }}</h5>
                        <small class="text-white">{{ $class->name }}</small>
                    </div>
                    @if(Auth::user()->role === 'teacher' && $assignment->teacher_id === Auth::id())
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-light" type="button" data-bs-toggle="dropdown">
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
            </div>
            <div class="card-body mt-3">
                <!-- Assignment Info -->
                <div class="row g-3 mb-4 p-3 bg-light rounded">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-calendar text-dark me-2" style="font-size: 1.5rem;"></i>
                            <div>
                                <small class="text-muted d-block">Deadline</small>
                                <strong>{{ $assignment->due_date->format('d M Y') }}</strong>
                                <br><small>{{ $assignment->due_date->format('H:i') }} WIB</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-star text-warning me-2" style="font-size: 1.5rem;"></i>
                            <div>
                                <small class="text-muted d-block">Nilai Max</small>
                                <strong>{{ $assignment->max_score }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-clock text-dark me-2" style="font-size: 1.5rem;"></i>
                            <div>
                                <small class="text-muted d-block">Status</small>
                                @if($assignment->isOverdue())
                                <span class="badge bg-danger">Terlambat</span>
                                @else
                                <span class="badge bg-{{ $assignment->getDaysLeft() <= 2 ? 'warning' : 'success' }}">
                                    {{ $assignment->getTimeLeft() }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-person text-secondary me-2" style="font-size: 1.5rem;"></i>
                            <div>
                                <small class="text-muted d-block">Pengajar</small>
                                <strong>{{ $assignment->teacher->display_name }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Assignment Description -->
                <div class="mb-4">
                    <h6>Deskripsi Tugas:</h6>
                    <div class="bg-light p-3 rounded">
                        {!! nl2br(e($assignment->description)) !!}
                    </div>
                </div>

                @if(Auth::user()->role === 'student')
                <!-- Student Submission Section -->
                <div class="card shadow-sm">
                    <div class="card-header text-white" style="background-color: #050d1c;">
                        <h6 class="mb-0">
                            <i class="bi bi-upload me-2"></i>Pengumpulan Tugas
                        </h6>
                    </div>
                    <div class="card-body">
                        @if(isset($submission) && $submission->isSubmitted())
                        <h6>Jawaban Anda:</h6>
                        @if($submission->content)
                        <div class="bg-light p-3 rounded mb-3">
                            {!! nl2br(e($submission->content)) !!}
                        </div>
                        @endif

                        @if($submission->file_path)
                        <div class="d-flex align-items-center bg-light p-3 rounded">
                            <i class="bi bi-file-earmark-text text-dark me-3" style="font-size: 2rem;"></i>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">File Lampiran</h6>
                                <small class="text-muted">{{ $submission->original_filename ?? basename($submission->file_path) }}</small>
                            </div>
                            <a href="{{ route('submissions.download', $submission) }}" class="btn btn-outline-success">
                                <i class="bi bi-download me-1"></i>Unduh
                            </a>
                        </div>
                        @endif

                        @if(!$assignment->isOverdue())
                        <hr>
                        <p class="text-muted mb-0">
                            <i class="bi bi-info-circle me-1"></i>
                            Anda masih bisa memperbarui jawaban sebelum deadline.
                        </p>
                        @endif

                        @else
                        <!-- Not Submitted Yet -->
                        @if($assignment->isOverdue())
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>Waktu pengumpulan sudah berakhir!</strong>
                        </div>
                        @else
                        <!-- Submission Form -->
                        <form method="POST" action="{{ route('assignments.submit', $assignment) }}" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="content" class="form-label">Jawaban Tugas</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" 
                                          id="content" name="content" rows="8"
                                          placeholder="Tulis jawaban Anda di sini...">{{ old('content', $submission->content ?? '') }}</textarea>
                                @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="file" class="form-label">Upload File (Opsional)</label>
                                <input type="file" class="form-control @error('file') is-invalid @enderror" 
                                       id="file" name="file" accept=".pdf,.doc,.docx,.txt,.jpg,.jpeg,.png">
                                @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Format yang diizinkan: PDF, DOC, DOCX, TXT, JPG, PNG. Maksimal 10MB.
                                </div>
                            </div>

                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <strong>Peringatan:</strong> Pastikan jawaban Anda sudah benar sebelum dikumpulkan.
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-upload me-2"></i>Kumpulkan Tugas
                            </button>
                        </form>
                        @endif
                        @endif
                    </div>
                </div>
                @else
                <!-- Teacher View - Submissions List -->
                <div class="card shadow-sm mt-4">
                    <div class="card-header text-white" style="background-color: #050d1c;">
                        <h6 class="mb-0">
                            <i class="bi bi-people me-2"></i>Daftar Pengumpulan Siswa
                        </h6>
                    </div>
                    <div class="card-body">
                        @if(isset($submissions) && $submissions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Siswa</th>
                                        <th>Status</th>
                                        <th>Dikumpulkan</th>
                                        <th>Nilai</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($submissions as $sub)
                                    <tr>
                                        <td>
                                            <strong>{{ $sub->student->display_name }}</strong>
                                            <br><small class="text-muted">{{ $sub->student->email }}</small>
                                        </td>
                                        <td>
                                            @if($sub->isSubmitted())
                                            <span class="badge bg-success">Dikumpulkan</span>
                                            @else
                                            <span class="badge bg-warning">Belum</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($sub->submitted_at)
                                            {{ $sub->submitted_at->format('d M Y, H:i') }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                        <td>
                                            @if($sub->isGraded())
                                            <span class="badge bg-primary">{{ $sub->score }}/{{ $assignment->max_score }}</span>
                                            @elseif($sub->isSubmitted())
                                            <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#gradeModal{{ $sub->id }}">
                                                Beri Nilai
                                            </button>
                                            @else
                                            -
                                            @endif
                                        </td>
                                        <td>
                                            @if($sub->isSubmitted())
                                            <button class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#viewModal{{ $sub->id }}">
                                                <i class="bi bi-eye"></i> Lihat
                                            </button>
                                            @endif
                                        </td>
                                    </tr>

                                    @if($sub->isSubmitted())
                                    <!-- View Modal -->
                                    <div class="modal fade" id="viewModal{{ $sub->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header text-white" style="background-color: #050d1c;">
                                                    <h5 class="modal-title">Jawaban - {{ $sub->student->display_name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    @if($sub->content)
                                                    <h6>Jawaban:</h6>
                                                    <div class="bg-light p-3 rounded mb-3">
                                                        {!! nl2br(e($sub->content)) !!}
                                                    </div>
                                                    @endif

                                                    @if($sub->file_path)
                                                    <h6>File Lampiran:</h6>
                                                    <div class="d-flex align-items-center bg-light p-3 rounded">
                                                        <i class="bi bi-file-earmark-text text-black me-3" style="font-size: 2rem;"></i>
                                                        <div class="flex-grow-1">
                                                            <strong>{{ $sub->original_filename ?? basename($sub->file_path) }}</strong>
                                                        </div>
                                                        <a href="{{ route('submissions.download', $sub) }}" class="btn btn-outline-success">
                                                            <i class="bi bi-download me-1"></i>Unduh
                                                        </a>
                                                    </div>
                                                    @endif

                                                    <hr>
                                                    <small class="text-muted">
                                                        Dikumpulkan pada: {{ $sub->submitted_at->format('d M Y, H:i') }} WIB
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Grade Modal -->
                                    @if(!$sub->isGraded())
                                    <div class="modal fade" id="gradeModal{{ $sub->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Beri Nilai - {{ $sub->student->display_name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form method="POST" action="{{ route('assignments.grade', [$assignment, $sub]) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="score{{ $sub->id }}" class="form-label">Nilai (0-{{ $assignment->max_score }})</label>
                                                            <input type="number" class="form-control" id="score{{ $sub->id }}" name="score" 
                                                                   min="0" max="{{ $assignment->max_score }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="feedback{{ $sub->id }}" class="form-label">Feedback (Opsional)</label>
                                                            <textarea class="form-control" id="feedback{{ $sub->id }}" name="feedback" rows="3"
                                                                      placeholder="Berikan feedback untuk siswa..."></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-success">Simpan Nilai</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-4">
                            <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                            <h5 class="mt-3 text-muted">Belum ada pengumpulan</h5>
                            <p class="text-muted">Siswa akan muncul di sini setelah mengumpulkan tugas</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
            <div class="card-footer">
                <div class="d-flex gap-2">
                    <a href="{{ route('assignments.index', $class) }}" class="btn btn-danger">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

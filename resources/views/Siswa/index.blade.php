@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<h1 class="py-3">Selamat datang {{ Auth::user()->name }}</h1>

<div class="modal fade" id="joinClassModal" tabindex="-1" aria-labelledby="joinClassModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('siswa.joinClass') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="joinClassModalLabel">Gabung Kelas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="kode_kelas" class="form-label">Kode Kelas</label>
            <input type="text" class="form-control" id="kode_kelas" name="kode_kelas" placeholder="Masukkan kode kelas" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Gabung</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="row">
    {{-- @foreach ($kelas as $kls)
        <div class="col-md-4 mb-3">
            <a href="#" class="btn">
                <div class="card">
                    <div class="card-body">
                        <div class="card">
                            <img src="{{ asset('img/bg1.jpg') }}" alt="Gambar Kartu" class="img-fluid">
                        </div>
                        <div class="px-3">
                            <h5 class="card-title py-3 text-start">{{ $kls->nama_kelas }}</h5>
                            <div class="text-end">
                                <a href="#" class="btn btn-outline-dark">Lihat Kelas</a>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach --}}
    @for ($i = 0; $i < 4; $i++)
        <div class="col-md-4 mb-3">
            <a href="#" class="btn">
                <div class="card">
                    <div class="card-body">
                        <div class="card">
                            <img src="{{ asset('img/bg1.jpg') }}" alt="Gambar Kartu" class="img-fluid">
                        </div>
                        <div class="px-3">
                            <h5 class="card-title py-3 text-start">Interaksi Manusia Komputer</h5>
                            <div class="text-end">
                                <a href="#" class="btn btn-outline-dark">Lihat Kelas</a>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endfor
</div>

{{-- <script>
document.addEventListener("DOMContentLoaded", function () {
    @if(auth()->user() && auth()->user()->role === 'siswa')
    const plusBtn = document.querySelector('.btn[data-bs-toggle="tooltip"]');
    if (plusBtn) {
        plusBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const joinModal = new bootstrap.Modal(document.getElementById('joinClassModal'));
            joinModal.show();
        });
    }
    // Pindahkan fokus ke tombol plus setelah modal ditutup
    const joinClassModal = document.getElementById('joinClassModal');
    if (joinClassModal && plusBtn) {
        joinClassModal.addEventListener('hidden.bs.modal', function () {
            plusBtn.focus();
        });
    }
    @endif
});
</script> --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    @if(auth()->user() && auth()->user()->role === 'siswa')
    // Tombol plus di navbar desktop
    const plusBtn = document.querySelector('.btn[data-bs-toggle="tooltip"]');
    // Tombol plus di sidebar mobile
    const plusBtnMobile = document.getElementById('joinClassMobileBtn');
    // Modal
    const joinClassModal = document.getElementById('joinClassModal');

    function showJoinModal(e) {
        e.preventDefault();
        if (joinClassModal) {
            const joinModal = new bootstrap.Modal(joinClassModal);
            joinModal.show();
        }
    }

    if (plusBtn) {
        plusBtn.addEventListener('click', showJoinModal);
    }
    if (plusBtnMobile) {
        plusBtnMobile.addEventListener('click', showJoinModal);
    }
    // Pindahkan fokus ke tombol plus setelah modal ditutup (aksesibilitas)
    if (joinClassModal && plusBtn) {
        joinClassModal.addEventListener('hidden.bs.modal', function () {
            plusBtn.focus();
        });
    }
    @endif
});
</script>
@endsection
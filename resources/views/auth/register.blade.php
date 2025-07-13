@extends('layouts.auth')

@section('title', 'Register')

@section('content') 
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5" style="max-width: 500px">
        <div class="card rounded-4 shadow p-3 bg-light">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <h3 class="mt-2">ClAssign</h3>
                    <p class="small">Registrasi akun ClAssign dulu ya!</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="nama" id="name" name="name" value="{{ old('name') }}" required>
                        <label for="name">Nama Lengkap</label>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control bg-transparent  @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="email@example.com" required>
                        <label for="email">Email</label>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-select bg-transparent @error('role') is-invalid @enderror" id="role" name="role" aria-label="Role" required>
                            <option value="">Pilih peran Anda</option>
                            <option value="student" {{ old('role') === 'student' ? 'selected' : '' }}>Siswa</option>
                            <option value="teacher" {{ old('role') === 'teacher' ? 'selected' : '' }}>Pengajar</option>
                        </select>
                        <label for="role" >Peran</label>
                        @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control bg-transparent @error('password') is-invalid @enderror" id="password" name="password" placeholder='pasword' required>
                        <label for="password">Password</label>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control bg-transparent" id="password_confirmation" name="password_confirmation" placeholder="password" required>
                        <label for="password_confirmation">Konfirmasi Password</label>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-dark rounded-5">Daftar</button>
                    </div>
                </form>

                <hr class="my-4">
                
                <div class="text-center">
                    <p class="mb-0">Sudah punya akun? 
                        <a href="{{ route('login') }}" class="fw-semibold">Masuk</a>
                    </p>
                </div>

                <div class="me-auto mt-3">
                    <a href="{{ route('index') }}" class="btn btn-dark rounded-3">
                        <i class="bi bi-caret-left"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
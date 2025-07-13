@extends('layouts.auth')

@section('title', 'Masuk - ClAssign')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4" style="max-width: 500px">
        <div class="card rounded-4 shadow bg-light p-3">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <h3 class="mt-2">ClAssign</h3>
                    <p class="small">Selamat datang, belajar lebih menyenangkan dengan ClAssign!</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control bg-transparent @error('email') is-invalid @enderror" id="email" name="email" placeholder="email@example.com" value="{{ old('email') }}" required >
                        <label for="email" >Email</label>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control bg-transparent @error('password') is-invalid @enderror" id="password" name="password" placeholder="password" required>
                        <label for="password" >Password</label>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-dark rounded-5">Masuk</button>
                    </div>
                </form>

                <hr class="my-4">
                
                <div class="text-center">
                    <p class="mb-0">Belum punya akun? 
                        <a href="{{ route('register') }}" class="fw-semibold">Daftar</a>
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
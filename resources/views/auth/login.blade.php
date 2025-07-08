@extends('layouts.auth')

@section('title', 'Masuk')

@section('content')
<div class="row justify-content-center">
    <div class="col-sm-5" style="max-width: 500px">
        <div class="card rounded-4 shadow p-3 text-white" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(3px)">
            <div class="card-body">
                <div class="row" id="signin-form">
                    <div class="col">
                        <div class="container">
                            <div class="text-center">
                            <h2>ClAssign</h2>
                            <small>Selamat datang, belajar lebih menyenangkan dengan ClAssign!</small>
                            </div>
                            
                            <form action="{{ route('login') }}" method="POST">
                                @csrf
                                @if(request('role'))
                                    <input type="hidden" name="role" value="{{ request('role') }}">
                                @endif
                                <div class="form-floating mb-1">
                                    <input type="email" 
                                            name="email"
                                            class="form-control text-white @error('email') is-invalid @enderror" 
                                            style="border: none; background: transparent; border-bottom: solid; border-radius: 0" 
                                            id="signin-email" 
                                            placeholder="name@example.com" 
                                            required 
                                            value="{{ old('email') }}"
                                    />
                                    <label for="signin-email" class="text-white fw-light">Email</label>
                                    @error('email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-floating mb-1">
                                    <input type="password" 
                                            name="password"
                                            class="form-control text-white @error('password') is-invalid @enderror" 
                                            style="border: none; background: transparent; border-bottom: solid; border-radius: 0" 
                                            id="signin-password" 
                                            placeholder="password" 
                                            required 
                                    />
                                    <label for="signin-password" class="text-white fw-light">Password</label>
                                    @error('password')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-check form-check-inline mb-1">
                                    <input class="form-check-input" 
                                            type="checkbox" 
                                            name="remember" 
                                            id="signin-check" 
                                            {{ old('remember') ? 'checked' : '' }}
                                    />
                                    <label class="form-check-label" for="signin-check">Ingat saya</label>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-outline-light w-100 my-3 rounded-5">Masuk</button>
                                </div>

                                <div class="text-center">
                                    <small class="text-wrap fw-light">
                                        Belum punya akun? 
                                        <a class="text-white fw-semibold" href="{{ route('register', request('role') ? ['role' => request('role')] : []) }}">Daftar</a>
                                    </small>
                                </div>
                            </form>

                            <div class="me-auto mt-3">
                                <a href="{{ url('/') }}" class="btn btn-outline-light rounded-3">
                                    <i class="bi bi-caret-left"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
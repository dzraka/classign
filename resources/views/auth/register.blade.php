@extends('layouts.auth')

@section('title', 'Register')

@section('content')
    <div class="row justify-content-center">
        <div class="col-sm-5" style="max-width: 500px">
            <div class="card rounded-4 shadow p-3 text-white" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(3px)">
                <div class="card-body">
                    <div class="row" id="register-form">
                        <div class="col">
                            <div class="container">
                              <div class="text-center">
                                <h2>ClAssign</h2>
                                <small>Registrasi akun ClAssign dulu ya!</small>
                              </div>
                                <form action="{{ route('register') }}" method="POST">
                                    @csrf
                                    <div class="form-floating mb-1">
                                        <input type="text"
                                               name="name"
                                               class="form-control text-white @error('name') is-invalid @enderror"
                                               style="border: none; background: transparent; border-bottom: solid; border-radius: 0"
                                               id="register-name"
                                               placeholder="Nama Lengkap"
                                               required
                                               value="{{ old('name') }}"
                                        />
                                        <label for="register-name" class="text-white fw-light">Nama Lengkap</label>
                                        @error('name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="email"
                                               name="email"
                                               class="form-control text-white @error('email') is-invalid @enderror"
                                               style="border: none; background: transparent; border-bottom: solid; border-radius: 0"
                                               id="register-email"
                                               placeholder="name@example.com"
                                               required
                                               value="{{ old('email') }}"
                                        />
                                        <label for="register-email" class="text-white fw-light">Email</label>
                                        @error('email')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="password"
                                               name="password"
                                               class="form-control text-white @error('password') is-invalid @enderror"
                                               style="border: none; background: transparent; border-bottom: solid; border-radius: 0"
                                               id="register-password"
                                               placeholder="Password"
                                               required
                                        />
                                        <label for="register-password" class="text-white fw-light">Password</label>
                                        @error('password')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="password"
                                               name="password_confirmation"
                                               class="form-control text-white @error('password_confirmation') is-invalid @enderror"
                                               style="border: none; background: transparent; border-bottom: solid; border-radius: 0"
                                               id="register-password-confirmation"
                                               placeholder="Konfirmasi Password"
                                               required
                                        />
                                        <label for="register-password-confirmation" class="text-white fw-light">Konfirmasi Password</label>
                                        @error('password_confirmation')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="hidden" name="role" value="{{ request('role', old('role')) }}">
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-outline-light w-100 my-3 rounded-5">Register</button>
                                    </div>
                                    <div class="text-center">
                                        <small class="text-wrap fw-light">
                                            Sudah punya akun? <a class="text-white fw-semibold" href="{{ route('login') }}">Masuk</a>
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

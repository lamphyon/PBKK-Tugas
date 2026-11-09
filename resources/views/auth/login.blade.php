@extends('layouts.auth')

@section('title', 'Login')
@section('heading', 'Masuk ke Backoffice')

@section('auth_content')
    <p class="text-body-secondary small">Gunakan akun Anda untuk mengelola data akademik.</p>
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control" autocomplete="username" required autofocus>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-control" autocomplete="current-password" required>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3 gap-2">
            <div class="form-check">
                <input type="checkbox" id="remember" name="remember" class="form-check-input" @checked(old('remember'))>
                <label for="remember" class="form-check-label small">Ingat saya</label>
            </div>
            <a href="{{ route('password.request') }}" class="small">Lupa password?</a>
        </div>
        <button type="submit" class="btn btn-primary w-100">Masuk</button>
    </form>
    <p class="small text-center mt-3 mb-0">Belum punya akun? <a href="{{ route('register') }}">Daftar sebagai Staf</a></p>

    {{-- Tombol demo tidak membawa password dan tetap memakai POST + CSRF. --}}
    @if (app()->environment(['local', 'testing']) && config('demo.login_enabled'))
        <div class="border-top mt-4 pt-3">
            <p class="fw-semibold small mb-1">Coba akun demo</p>
            <p class="text-body-secondary small">Login instan untuk evaluasi lokal.</p>
            <div class="d-flex gap-2">
                <form action="{{ route('demo.login', 'admin') }}" method="POST" class="flex-fill">
                    @csrf
                    <button class="btn btn-outline-primary w-100" type="submit">Masuk Admin</button>
                </form>
                <form action="{{ route('demo.login', 'staf') }}" method="POST" class="flex-fill">
                    @csrf
                    <button class="btn btn-outline-secondary w-100" type="submit">Masuk Staf</button>
                </form>
            </div>
        </div>
    @endif
@stop

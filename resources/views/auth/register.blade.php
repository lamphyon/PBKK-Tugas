@extends('layouts.auth')

@section('title', 'Daftar')
@section('heading', 'Daftar Akun Staf')

@section('auth_content')
    <p class="text-body-secondary small">Akun baru mendapat peran Staf dan wajib memverifikasi email.</p>
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama lengkap</label>
            <input id="name" name="name" value="{{ old('name') }}" class="form-control" maxlength="255" autocomplete="name" required autofocus>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control" maxlength="255" autocomplete="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-control" minlength="8" autocomplete="new-password" required>
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" minlength="8" autocomplete="new-password" required>
        </div>
        <button class="btn btn-primary w-100" type="submit">Buat Akun</button>
    </form>
    <p class="small text-center mt-3 mb-0">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
@stop

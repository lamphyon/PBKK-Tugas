@extends('layouts.auth')

@section('title', 'Password Baru')
@section('heading', 'Buat Password Baru')

@section('auth_content')
    <form action="{{ route('password.store') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $request->email) }}" class="form-control" autocomplete="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password baru</label>
            <input type="password" id="password" name="password" class="form-control" minlength="8" autocomplete="new-password" required autofocus>
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" minlength="8" autocomplete="new-password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Simpan Password</button>
    </form>
@stop

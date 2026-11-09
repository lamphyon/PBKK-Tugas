@extends('layouts.auth')

@section('title', 'Lupa Password')
@section('heading', 'Reset Password')

@section('auth_content')
    <p class="text-body-secondary small">Masukkan email Anda untuk menerima tautan reset password.</p>
    <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control" autocomplete="username" required autofocus>
        </div>
        <button type="submit" class="btn btn-primary w-100">Kirim Tautan Reset</button>
    </form>
    <a href="{{ route('login') }}" class="small d-block mt-3">Kembali ke login</a>
@stop

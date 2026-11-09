@extends('layouts.auth')

@section('title', 'Konfirmasi Password')
@section('heading', 'Konfirmasi Password')

@section('auth_content')
    <p class="text-body-secondary small">Masukkan password Anda untuk melanjutkan.</p>
    <form action="{{ route('password.confirm') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-control" autocomplete="current-password" required autofocus>
        </div>
        <button type="submit" class="btn btn-primary w-100">Konfirmasi</button>
    </form>
@stop

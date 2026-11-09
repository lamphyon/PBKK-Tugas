@extends('layouts.auth')

@section('title', 'Verifikasi Email')
@section('heading', 'Verifikasi Email Anda')

@section('auth_content')
    <p class="text-body-secondary small">Buka tautan verifikasi yang dikirim ke {{ auth()->user()->email }} sebelum mengakses dashboard.</p>
    @if (session('status') === 'verification-link-sent')
        <p class="text-success small">Tautan verifikasi baru telah dikirim.</p>
    @endif
    <form action="{{ route('verification.send') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary w-100">Kirim Ulang Email Verifikasi</button>
    </form>
    <form action="{{ route('logout') }}" method="POST" class="mt-2">
        @csrf
        <button type="submit" class="btn btn-outline-secondary w-100">Keluar</button>
    </form>
@stop

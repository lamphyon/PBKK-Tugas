{{-- Controller dan validasi memakai Breeze; tampilan mengikuti Bootstrap AdminLTE. --}}
@extends('adminlte::auth.auth-page', ['authType' => 'login'])

@section('auth_header')
    @yield('heading', 'Portal Akademik')
@stop

@section('auth_body')
    @if (session('status'))
        <div class="alert alert-success small" role="status">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger small" role="alert">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('auth_content')
@stop

@section('auth_footer')
    <a href="{{ route('home') }}" class="small">&larr; Kembali ke beranda</a>
@stop

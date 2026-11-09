{{-- Semua halaman backoffice mewarisi layout asli paket AdminLTE. --}}
@extends('adminlte::page')

@section('content_header')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-2">
        <div>
            <div class="text-body-secondary small mb-1">PORTAL AKADEMIK / BACKOFFICE</div>
            <h1 class="fs-3 fw-semibold mb-0">@yield('page_title', 'Dashboard')</h1>
        </div>
        <span class="badge rounded-pill text-bg-primary px-3 py-2">
            <i class="bi bi-person-check me-1" aria-hidden="true"></i>
            {{ auth()->user()->getRoleNames()->implode(', ') ?: 'Tanpa peran' }}
        </span>
    </div>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success" role="status">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <strong>Periksa kembali isian berikut:</strong>
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('admin_content')
@stop

@section('footer')
    <span class="text-body-secondary">Portal Akademik &copy; {{ date('Y') }}</span>
    <span class="float-end d-none d-sm-inline text-body-secondary">PBKK · Dashboard &amp; RBAC</span>
@stop

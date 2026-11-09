@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('admin_content')
    <p class="text-body-secondary mb-4">Selamat datang, {{ auth()->user()->name }}. Berikut ringkasan data akademik saat ini.</p>

    {{-- Tiga widget wajib: nilainya dihitung oleh DashboardController. --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="small-box text-bg-primary mb-0">
                <div class="inner p-4">
                    <h3>{{ number_format($totalMahasiswa) }}</h3>
                    <p class="mb-0">Total Mahasiswa</p>
                </div>
                <i class="small-box-icon bi bi-mortarboard" aria-hidden="true"></i>
                @can('lihat mahasiswa')
                    <a href="{{ route('admin.mahasiswa.index') }}" class="small-box-footer py-2">
                        Lihat data <i class="bi bi-arrow-right-circle ms-1" aria-hidden="true"></i>
                    </a>
                @endcan
            </div>
        </div>
        <div class="col-md-4">
            <div class="small-box text-bg-success mb-0">
                <div class="inner p-4">
                    <h3>{{ number_format($totalProgramStudi) }}</h3>
                    <p class="mb-0">Program Studi</p>
                </div>
                <i class="small-box-icon bi bi-buildings" aria-hidden="true"></i>
                <div class="small-box-footer py-2">Program studi terdaftar</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="small-box text-bg-dark mb-0">
                <div class="inner p-4">
                    <h3>{{ number_format($totalPengguna) }}</h3>
                    <p class="mb-0">Pengguna Portal</p>
                </div>
                <i class="small-box-icon bi bi-people" aria-hidden="true"></i>
                <div class="small-box-footer py-2">Akun pengguna terdaftar</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header py-3">
                    <h2 class="card-title fw-semibold">Mahasiswa Terbaru</h2>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col" class="ps-3">Mahasiswa</th>
                                <th scope="col">Program Studi</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($mahasiswaTerbaru as $item)
                                <tr>
                                    <td class="ps-3">
                                        <div class="fw-semibold">{{ $item->nama }}</div>
                                        <small class="text-body-secondary">{{ $item->nrp }}</small>
                                    </td>
                                    <td>{{ $item->programStudi->nama }}</td>
                                    <td>
                                        <span class="badge {{ $item->status === 'Aktif' ? 'text-bg-success' : 'text-bg-secondary' }}">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-body-secondary py-4">Belum ada data mahasiswa.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header py-3">
                    <h2 class="card-title fw-semibold">Sebaran Program Studi</h2>
                </div>
                <ul class="list-group list-group-flush">
                    @forelse ($programStudi as $prodi)
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            {{ $prodi->nama }}<span class="badge text-bg-light border">{{ $prodi->mahasiswa_count }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-body-secondary">Belum ada program studi.</li>
                    @endforelse
                </ul>
            </div>
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="h6 fw-semibold"><i class="bi bi-shield-check me-1" aria-hidden="true"></i> Hak akses Anda</h2>
                    <p class="small text-body-secondary mb-0">Aksi yang tersedia mengikuti permission di database. Penghapusan data hanya tersedia untuk Admin.</p>
                </div>
            </div>
        </div>
    </div>
@stop

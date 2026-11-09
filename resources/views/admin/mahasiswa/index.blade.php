@extends('layouts.admin')

@section('title', 'Data Mahasiswa')
@section('page_title', 'Data Mahasiswa')

@section('admin_content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <p class="text-body-secondary mb-0">Kelola identitas dan status akademik mahasiswa.</p>
        @can('tambah mahasiswa')
            <a href="{{ route('admin.mahasiswa.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1" aria-hidden="true"></i> Tambah Mahasiswa</a>
        @endcan
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body border-bottom">
            {{-- GET membuat filter terlihat di URL dan bisa dibawa pagination. --}}
            <form action="{{ route('admin.mahasiswa.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-lg-4">
                    <label for="search" class="form-label">Cari mahasiswa</label>
                    <input type="search" id="search" name="search" value="{{ $filters['search'] ?? '' }}" class="form-control" placeholder="Nama, NRP, atau email" maxlength="100">
                </div>
                <div class="col-lg-3 col-sm-6">
                    <label for="program_studi_id" class="form-label">Program studi</label>
                    <select id="program_studi_id" name="program_studi_id" class="form-select">
                        <option value="">Semua program studi</option>
                        @foreach ($programStudi as $prodi)
                            <option value="{{ $prodi->id }}" @selected(($filters['program_studi_id'] ?? '') == $prodi->id)>{{ $prodi->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2 col-sm-6">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select">
                        <option value="">Semua status</option>
                        @foreach (['Aktif', 'Cuti', 'Lulus'] as $status)
                            <option @selected(($filters['status'] ?? '') === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3 d-flex gap-2">
                    <button class="btn btn-primary" type="submit"><i class="bi bi-search me-1" aria-hidden="true"></i> Cari</button>
                    <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <caption class="visually-hidden">Daftar mahasiswa sesuai filter pencarian</caption>
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-3">NRP</th>
                        <th scope="col">Mahasiswa</th>
                        <th scope="col">Program Studi</th>
                        <th scope="col">Angkatan</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="text-end pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mahasiswa as $item)
                        <tr>
                            <td class="ps-3 text-nowrap">{{ $item->nrp }}</td>
                            <td>
                                <div class="fw-semibold">{{ $item->nama }}</div>
                                <small class="text-body-secondary">{{ $item->email }}</small>
                            </td>
                            <td>{{ $item->programStudi->nama }}</td>
                            <td>{{ $item->angkatan }}</td>
                            <td>
                                <span class="badge {{ $item->status === 'Aktif' ? 'text-bg-success' : 'text-bg-secondary' }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="text-end pe-3 text-nowrap">
                                @can('ubah mahasiswa')
                                    <a href="{{ route('admin.mahasiswa.edit', $item) }}" class="btn btn-sm btn-outline-primary" aria-label="Ubah data {{ $item->nama }}">Ubah</a>
                                @endcan

                                {{-- Dua syarat yang sama dengan server: permission + Admin murni. --}}
                                @if (auth()->user()->hasExactRoles(['Admin']))
                                    @can('hapus mahasiswa')
                                        <form
                                            action="{{ route('admin.mahasiswa.destroy', $item) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Hapus data mahasiswa ini? Tindakan ini tidak dapat dibatalkan.');"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" aria-label="Hapus data {{ $item->nama }}">Hapus Data</button>
                                        </form>
                                    @endcan
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-body-secondary">
                                Tidak ada mahasiswa yang sesuai. Coba ubah filter atau tambah data baru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer pt-3">
            <p class="small text-body-secondary">Ditemukan {{ $mahasiswa->total() }} mahasiswa.</p>
            {{ $mahasiswa->links() }}
        </div>
    </div>
@stop

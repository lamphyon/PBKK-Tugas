@extends('layouts.admin')

@section('title', 'Ubah Mahasiswa')
@section('page_title', 'Ubah Mahasiswa')

@section('admin_content')
    <p class="text-body-secondary mb-4">Perbarui data {{ $mahasiswa->nama }}. Kolom bertanda * wajib diisi.</p>
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.mahasiswa.update', $mahasiswa) }}" method="POST">
                @method('PUT')
                @include('admin.mahasiswa._form')
            </form>
        </div>
    </div>
@stop

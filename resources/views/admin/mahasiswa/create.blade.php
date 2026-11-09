@extends('layouts.admin')

@section('title', 'Tambah Mahasiswa')
@section('page_title', 'Tambah Mahasiswa')

@section('admin_content')
    <p class="text-body-secondary mb-4">Isi identitas mahasiswa baru. Kolom bertanda * wajib diisi.</p>
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.mahasiswa.store') }}" method="POST">
                @include('admin.mahasiswa._form')
            </form>
        </div>
    </div>
@stop

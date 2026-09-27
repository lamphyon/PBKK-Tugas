{{--
    Profil Mahasiswa (/profil-mahasiswa) — Halaman profil diri mahasiswa
    Menggunakan master layout: layouts/app.blade.php
    ✅ Menggunakan komponen <x-info-card> untuk setiap item data
    📸 Taruh foto kamu di public/images/foto.jpg
--}}

@extends('layouts.app')

@section('title', 'Profil Mahasiswa — ITS Academic Profile')

@section('content')
<div class="min-h-[calc(100vh-7rem)] py-16 px-6">
    <div class="w-full max-w-4xl mx-auto">

        {{-- ============================================================
             HEADER PROFIL
        ============================================================ --}}
        <div class="text-center mb-12">
            <p class="text-emerald-400 text-xs font-bold tracking-[0.3em] uppercase mb-4">
                Student Profile
            </p>
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-3">
                Abdullah Sultan Barizy
            </h1>
            <p class="text-gray-500 text-sm">Informasi Profil Mahasiswa · Teknik Informatika ITS</p>
        </div>

        <div class="flex justify-center mb-12">
            <div class="relative">
                <img
                    src="https://image.ggwp.id/post/20260605/upload_7fd539f30a0104df966c9a1b10163b13_4ab131aa-9b14-4f05-887c-264f8ee3a9e9.jpg?tr=w-1200,f-webp,q-75&width=1200&format=webp&quality=75"
                    alt="Foto Profil Mahasiswa"
                    class="w-40 h-40 rounded-full object-cover border-4 border-emerald-500/50 shadow-[0_0_30px_rgba(16,185,129,0.25)]"
                    onerror="this.src='https://ui-avatars.com/api/?name=Mahasiswa+ITS&background=064e3b&color=34d399&size=200&bold=true'"
                />
                <span class="absolute bottom-2 right-2 w-5 h-5 bg-emerald-500 rounded-full border-2 border-gray-950 flex items-center justify-center" title="Mahasiswa Aktif">
                    <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-emerald-400 opacity-60"></span>
                </span>
            </div>
        </div>
   
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

            <x-info-card
                label="Nama Lengkap"
                icon="👤"
                accent="text-white font-bold"
                value="Abdullah Sultan Barizy"
            />

            <x-info-card
                label="NRP"
                icon="🔑"
                accent="text-emerald-400 font-mono text-lg"
                value="5025241092"
            />

        </div>

        {{-- Baris 2: Institusi --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

            <x-info-card
                label="Institusi"
                icon="🏛️"
                value="Institut Teknologi Sepuluh Nopember"
            />

            <x-info-card
                label="Departemen / Program Studi"
                icon="🎓"
                value="Teknik Informatika"
            />

        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">

            <x-info-card
                label="IPK"
                icon="📊"
                accent="text-emerald-400 font-bold text-xl"
                value="1.23"
            />

            <x-info-card
                label="Semester"
                icon="📅"
                accent="text-white font-bold"
                value="5"
            />

            <x-info-card
                label="Status"
                icon="✅"
                accent="text-emerald-400"
                value="Mahasiswa Aktif"
            />

        </div>

        {{-- Baris 4: Peminatan & Minat --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

            <x-info-card
                label="Peminatan"
                icon="🧠"
                accent="text-purple-400"
                value="Software Ternak Lele"
            />

            <x-info-card
                label="Hobi"
                icon="🎯"
                value="Tidur, Makan, dan Tidur"
            />

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

            <x-info-card
                label="Email"
                icon="📧"
                accent="text-blue-400 font-mono text-sm"
                value="5025241092@student.its.ac.id"
            />

            <x-info-card
                label="GitHub"
                icon="🐙"
                accent="text-gray-300 font-mono text-sm"
                value="github.com/lamphyon"
            />

        </div>

        <div class="mt-6">
            <x-info-card
                label="Tentang Aku"
                icon="📝"
                {{-- value dikosongkan, konten dimasukkan via slot --}}
                value=""
            >
                <p class="text-gray-300 leading-relaxed">
                    Aku adalah mahasiswa Teknik Informatika semester 5 yang berusaha untuk
                    Belajar PBKK agar aku bisa lulus dan mendapatkan kerja software engineer di perusahaan impianku. Aku juga memiliki hobi tidur, makan, dan tidur lagi. Semoga aku bisa lulus tepat waktu dan mendapatkan IPK yang memuaskan.
                    (mungkin).
                </p>
            </x-info-card>
        </div>

        <div class="mt-8">
            <x-status-banner
                type="info"
                message="Data profil ini bersifat statis. Hubungi pengelola untuk memperbarui informasi."
                :dismissible="true"
            />
        </div>

    </div>
</div>
@endsection
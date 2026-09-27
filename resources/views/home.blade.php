{{--
    Beranda (/) — Halaman utama website akademik ITS
    Menggunakan master layout: layouts/app.blade.php
    ✅ Tidak ada HTML boilerplate, navbar, atau footer di sini
--}}

@extends('layouts.app')

@section('title', 'Beranda — ITS Academic Profile')

@section('content')

    {{-- =====================================================================
         🔔 TANTANGAN 2: Alert Status Interaktif
         Menampilkan pesan selamat datang secara dinamis jika ada query param
         ?user=Nama di URL. Contoh: /beranda?user=Andi
         Komponen <x-status-banner> merender notifikasi dengan props dinamis.
    ====================================================================== --}}
    @if($user)
        <x-status-banner
            type="success"
            :message="'Selamat datang, ' . e($user) . '! 👋 Senang kamu ada di sini.'"
            :dismissible="true"
        />
    @endif

    {{-- Hero Section --}}
    <section class="flex-grow flex items-center justify-center py-12 px-6 min-h-[calc(100vh-7rem)]">
        <div class="w-full max-w-6xl grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

            {{-- Kiri: Hero Text & Rotating Team --}}
            <div class="space-y-6">
                <h1 class="text-4xl lg:text-5xl font-extrabold text-emerald-400 tracking-wide">
                    Welcome to Our Website
                </h1>

                <div class="space-y-3">
                    <p class="text-sm uppercase tracking-wider text-gray-400 font-semibold">The team consists of:</p>
                    <div class="p-4 bg-gray-900/80 backdrop-blur rounded-xl border border-gray-800 shadow-lg min-h-[80px] flex items-center justify-center text-center">
                        {{-- ID ini diambil oleh pages.js untuk animasi rotasi --}}
                        <span id="dynamic-team" class="font-bold text-white text-lg">
                            Addien Zafriyan Al Akhsan — 5025241058
                        </span>
                    </div>
                </div>

                <div class="p-4 rounded-xl border border-gray-800/60">
                    <p class="text-gray-400 text-sm leading-relaxed">
                        This is the homepage of the ITS Student Profile Static Information System.
                    </p>
                </div>

                {{-- CTA Button --}}
                <a href="{{ route('profil') }}"
                   class="inline-block mt-4 px-6 py-3 bg-emerald-500 hover:bg-emerald-400 text-gray-950 font-bold rounded-xl transition">
                    Lihat Profil Mahasiswa →
                </a>
            </div>

            {{-- Kanan: Terminal Dekoratif --}}
            <div class="relative flex items-center justify-center p-6 bg-gray-900/60 backdrop-blur rounded-2xl border border-gray-800 overflow-hidden min-h-[300px] shadow-2xl">

                {{-- Background Glow --}}
                <div class="absolute -top-12 -right-12 w-32 h-32 bg-emerald-500/10 rounded-full blur-2xl"></div>
                <div class="absolute -bottom-12 -left-12 w-32 h-32 bg-emerald-600/10 rounded-full blur-2xl"></div>

                {{-- Terminal Content --}}
                <div class="relative z-10 w-full space-y-4">
                    <div class="flex items-center justify-between border-b border-gray-800 pb-3">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-red-500/80 inline-block"></span>
                            <span class="w-3 h-3 rounded-full bg-yellow-500/80 inline-block"></span>
                            <span class="w-3 h-3 rounded-full bg-emerald-500/80 inline-block"></span>
                        </div>
                        <span class="text-xs text-gray-500 font-mono">system.status // active</span>
                    </div>

                    <div class="space-y-2 font-mono text-xs text-gray-400">
                        <p class="text-emerald-400">&gt; initializing profile_system...</p>
                        <p>&gt; loading team credentials [OK]</p>
                        <p>&gt; database connection established...</p>
                        <div class="p-3 bg-emerald-950/30 border border-emerald-500/20 rounded-lg text-emerald-300 flex items-center gap-2 mt-4">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                            </span>
                            <span>Live Rotation Active (1s interval)</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

@endsection

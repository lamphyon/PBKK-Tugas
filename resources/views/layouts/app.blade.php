<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ITS Academic Profile')</title>

    {{-- ✅ Asset CSS & JS dikelola Vite — TIDAK menggunakan CDN --}}
    @vite(['resources/css/app.css', 'resources/js/pages.js'])

    <style>
        /* Custom global styles — dikelola di sini agar tidak terulang di setiap view */
        .text-glow  { text-shadow: 0 0 25px rgba(16, 185, 129, 0.6); }
        .box-glow   { box-shadow: 0 0 40px rgba(16, 185, 129, 0.15); }
        .bg-grid-pattern {
            background-size: 40px 40px;
            background-image:
                linear-gradient(to right, rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255,255,255,0.03) 1px, transparent 1px);
        }
        ::-webkit-scrollbar       { width: 8px; }
        ::-webkit-scrollbar-track { background: #030712; }
        ::-webkit-scrollbar-thumb { background: #1f2937; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #374151; }
    </style>
</head>
<body class="bg-gray-950 text-gray-100 font-sans min-h-screen flex flex-col antialiased selection:bg-emerald-500 selection:text-white overflow-x-hidden">

    {{-- ===================== NAVBAR STATIS (Master Layout) ===================== --}}
    <nav class="bg-gray-900 border-b border-gray-800 h-14 sticky top-0 z-50 shadow-lg">
        <div class="max-w-5xl mx-auto h-full flex justify-between items-center px-6">

            {{-- Brand --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-emerald-400 font-black tracking-widest text-lg text-glow">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                </svg>
                ITS<span class="text-white font-light">.dev</span>
            </a>

            {{-- Nav Links --}}
            <div class="flex items-center gap-6 text-sm font-semibold">
                <a href="{{ route('home') }}"
                   class="{{ request()->routeIs('home') ? 'text-emerald-400' : 'text-gray-400 hover:text-gray-200' }} transition">
                    Beranda
                </a>
                <a href="{{ route('profil') }}"
                   class="{{ request()->routeIs('profil') ? 'text-emerald-400' : 'text-gray-400 hover:text-gray-200' }} transition">
                    Profil Mahasiswa
                </a>
                <a href="{{ route('ide-agent') }}"
                   class="{{ request()->routeIs('ide-agent') ? 'text-emerald-400' : 'text-gray-400 hover:text-gray-200' }} transition">
                    Ide-Riset
                </a>
            </div>

        </div>
    </nav>

    {{-- ===================== KONTEN HALAMAN ANAK ===================== --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- ===================== FOOTER ITS ===================== --}}
    <footer class="bg-gray-950 border-t border-gray-800 py-8 px-6">
        <div class="max-w-5xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-gray-500">

            <div class="flex items-center gap-3">
                {{-- Logo ITS text placeholder --}}
                <div class="w-8 h-8 rounded-full bg-blue-800/60 border border-blue-600/40 flex items-center justify-center text-blue-300 font-black text-xs">
                    ITS
                </div>
                <div>
                    <p class="text-gray-300 font-semibold text-sm">Institut Teknologi Sepuluh Nopember</p>
                    <p class="text-gray-500 text-xs">Departemen Teknik Informatika</p>
                </div>
            </div>

            <div class="text-center text-xs text-gray-600">
                <p>PBKK Tugas 2 &copy; {{ date('Y') }} — Dibangun dengan Laravel &amp; Tailwind CSS via Vite</p>
                <p class="mt-1">Surabaya, Indonesia</p>
            </div>

            <div class="text-xs text-gray-600 text-right">
                <p>Powered by</p>
                <p class="text-emerald-500/70 font-mono">Laravel 11 + Vite + TailwindCSS v4</p>
            </div>

        </div>
    </footer>

</body>
</html>

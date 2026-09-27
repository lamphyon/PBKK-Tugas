{{--
    Komponen: <x-status-banner>
    Digunakan untuk menampilkan notifikasi / pesan status di atas halaman.

    Props:
      - type        : 'success' | 'info' | 'warning' | 'error'  (default: 'info')
      - message     : string — pesan yang ditampilkan
      - dismissible : bool   — apakah bisa ditutup (default: true)
      - icon        : string — override emoji ikon (opsional)

    Contoh penggunaan:
      <x-status-banner type="success" message="Selamat datang, Andi!" />
      <x-status-banner type="info"    message="Halaman ini masih dalam pengembangan." :dismissible="false" />

    ⚡ Tantangan 2: Komponen ini dipakai di home.blade.php untuk menampilkan
       pesan selamat datang dinamis berdasarkan query param ?user=Nama.
--}}

@props([
    'type'        => 'info',
    'message'     => '',
    'dismissible' => true,
    'icon'        => null,
])

@php
    $styles = match($type) {
        'success' => [
            'wrapper' => 'bg-emerald-950/60 border-emerald-500/40 text-emerald-300',
            'icon'    => $icon ?? '🎉',
            'dot'     => 'bg-emerald-400',
            'btn'     => 'text-emerald-400 hover:text-emerald-200',
        ],
        'warning' => [
            'wrapper' => 'bg-amber-950/60 border-amber-500/40 text-amber-300',
            'icon'    => $icon ?? '⚠️',
            'dot'     => 'bg-amber-400',
            'btn'     => 'text-amber-400 hover:text-amber-200',
        ],
        'error' => [
            'wrapper' => 'bg-red-950/60 border-red-500/40 text-red-300',
            'icon'    => $icon ?? '❌',
            'dot'     => 'bg-red-400',
            'btn'     => 'text-red-400 hover:text-red-200',
        ],
        default => [ // 'info'
            'wrapper' => 'bg-blue-950/60 border-blue-500/40 text-blue-300',
            'icon'    => $icon ?? 'ℹ️',
            'dot'     => 'bg-blue-400',
            'btn'     => 'text-blue-400 hover:text-blue-200',
        ],
    };
@endphp

@if($message)
<div
    id="status-banner"
    role="alert"
    class="w-full border {{ $styles['wrapper'] }} px-5 py-3.5 flex items-center justify-between gap-4 text-sm font-medium transition-all duration-300"
>
    {{-- Kiri: ikon + animasi dot + pesan --}}
    <div class="flex items-center gap-3">
        {{-- Animasi dot "live" --}}
        <span class="relative flex h-2 w-2 shrink-0">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $styles['dot'] }} opacity-60"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 {{ $styles['dot'] }}"></span>
        </span>

        {{-- Ikon & Pesan --}}
        <span class="text-base" aria-hidden="true">{{ $styles['icon'] }}</span>
        <span>{{ $message }}</span>
    </div>

    {{-- Kanan: tombol dismiss --}}
    @if($dismissible)
    <button
        type="button"
        onclick="document.getElementById('status-banner').style.display='none'"
        class="{{ $styles['btn'] }} transition text-lg leading-none font-bold shrink-0"
        aria-label="Tutup notifikasi"
    >
        &times;
    </button>
    @endif

</div>
@endif

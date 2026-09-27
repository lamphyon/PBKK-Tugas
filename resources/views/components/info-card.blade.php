{{--
    Komponen: <x-info-card>
    Digunakan untuk menampilkan satu item data profil mahasiswa.

    Props:
      - label   : string  — nama field (misal "Nama Lengkap", "NRP")
      - value   : string  — nilai field (bisa dikosongkan sementara)
      - accent  : string  — warna kelas Tailwind untuk value (opsional, default "text-white")
      - icon    : string  — emoji atau karakter ikon (opsional)

    Contoh penggunaan:
      <x-info-card label="NRP"   value="5025241XXX"  accent="text-emerald-400" icon="🔑" />
      <x-info-card label="Nama" :value="$namaLengkap" />
--}}

@props([
    'label'  => 'Label',
    'value'  => '—',
    'accent' => 'text-white',
    'icon'   => null,
])

<div class="group bg-gray-900/60 border border-gray-800 hover:border-emerald-500/30 rounded-xl p-5 transition duration-300 hover:shadow-[0_0_20px_rgba(16,185,129,0.08)]">

    {{-- Label --}}
    <p class="text-gray-500 text-xs font-semibold uppercase tracking-widest mb-2 flex items-center gap-1.5">
        @if($icon)
            <span>{{ $icon }}</span>
        @else
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500/50 inline-block"></span>
        @endif
        {{ $label }}
    </p>

    {{-- Value --}}
    <p class="font-semibold text-base leading-snug {{ $accent }}">
        {{ $value }}
    </p>

    {{-- Slot opsional untuk konten tambahan --}}
    @if($slot->isNotEmpty())
        <div class="mt-3 pt-3 border-t border-gray-800 text-sm text-gray-400">
            {{ $slot }}
        </div>
    @endif

</div>

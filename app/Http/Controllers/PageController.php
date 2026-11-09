<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Beranda (/)
     * Tantangan 2: Menampilkan banner selamat datang dinamis
     * jika query param ?user=Nama disertakan di URL.
     * Contoh: http://localhost:8000/?user=Andi
     */
    public function home(Request $request): View
    {
        // Ambil nilai dari query param ?user=... (null jika tidak ada)
        $user = $request->query('user');

        return view('home', compact('user'));
    }

    /**
     * Profil Mahasiswa (/profil-mahasiswa)
     * Menampilkan halaman profil diri dengan komponen <x-info-card>
     */
    public function profil(): View
    {
        return view('mahasiswa');
    }

    /**
     * Ide-Riset (/ide-agent)
     * Menampilkan halaman pitch platform Agentic AI (MAGENTIC)
     */
    public function ideAgent(): View
    {
        return view('agent');
    }

    // ──────────────────────────────────────────────────────────
    // Method warisan (dipertahankan untuk kompatibilitas)
    // ──────────────────────────────────────────────────────────

    public function about(): View
    {
        return view('about');
    }

    public function agent(?string $tema = null): View
    {
        if ($tema === null) {
            return view('agentdefault', ['tema' => 'General Assistant Agent']);
        }

        return view('agent', compact('tema'));
    }

    public function mahasiswaDetail(string $nrp): View
    {
        return view('mahasiswa', compact('nrp'));
    }
}

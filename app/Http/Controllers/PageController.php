<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Beranda (/)
     * Tantangan 2: Menampilkan banner selamat datang dinamis
     * jika query param ?user=Nama disertakan di URL.
     * Contoh: http://localhost:8000/?user=Andi
     */
    public function home(Request $request)
    {
        // Ambil nilai dari query param ?user=... (null jika tidak ada)
        $user = $request->query('user');

        return view('home', compact('user'));
    }

    /**
     * Profil Mahasiswa (/profil-mahasiswa)
     * Menampilkan halaman profil diri dengan komponen <x-info-card>
     */
    public function profil()
    {
        return view('mahasiswa');
    }

    /**
     * Ide-Riset (/ide-agent)
     * Menampilkan halaman pitch platform Agentic AI (MAGENTIC)
     */
    public function ideAgent()
    {
        return view('agent');
    }

    // ──────────────────────────────────────────────────────────
    // Method warisan (dipertahankan untuk kompatibilitas)
    // ──────────────────────────────────────────────────────────

    public function about()
    {
        return view('about');
    }

    public function agent($tema = null)
    {
        if ($tema === null) {
            return view('agentdefault', ['tema' => 'General Assistant Agent']);
        }

        return view('agent', compact('tema'));
    }

    public function mahasiswaDetail($nrp)
    {
        return view('mahasiswa', compact('nrp'));
    }
}
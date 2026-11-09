<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\View\View;

class DashboardController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return ['permission:lihat dashboard'];
    }

    public function index(): View
    {
        // Setiap angka berasal dari kueri database, bukan angka statis di Blade.
        return view('admin.dashboard', [
            'totalMahasiswa' => Mahasiswa::count(),
            'totalProgramStudi' => ProgramStudi::count(),
            'totalPengguna' => User::count(),
            'mahasiswaTerbaru' => Mahasiswa::with('programStudi')->latest('id')->limit(5)->get(),
            'programStudi' => ProgramStudi::withCount('mahasiswa')->orderBy('nama')->get(),
        ]);
    }
}

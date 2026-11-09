<?php

namespace App\Http\Controllers;

use App\Http\Requests\MahasiswaRequest;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

class MahasiswaController extends Controller implements HasMiddleware
{
    /** Middleware controller melindungi URL meskipun tombol disembunyikan. */
    public static function middleware(): array
    {
        // Laravel 13 menggunakan HasMiddleware sebagai pengganti constructor lama.
        return [
            new Middleware('permission:lihat mahasiswa', only: ['index']),
            new Middleware('permission:tambah mahasiswa', only: ['create', 'store']),
            new Middleware('permission:ubah mahasiswa', only: ['edit', 'update']),
            new Middleware('permission:hapus mahasiswa', only: ['destroy']),
        ];
    }

    public function index(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'program_studi_id' => ['nullable', 'integer', 'exists:program_studi,id'],
            'status' => ['nullable', 'in:Aktif,Cuti,Lulus'],
        ]);
        $search = trim($filters['search'] ?? '');

        $mahasiswa = Mahasiswa::with('programStudi')
            // when() menambahkan kondisi hanya ketika filter terisi.
            ->when($search !== '', function (Builder $query) use ($search) {
                // Kelompokkan OR supaya tetap tunduk pada filter prodi/status.
                $query->where(function (Builder $query) use ($search) {
                    $query->where('nama', 'like', '%'.$search.'%')
                        ->orWhere('nrp', 'like', '%'.$search.'%')
                        ->orWhere('email', 'like', '%'.$search.'%');
                });
            })
            ->when($filters['program_studi_id'] ?? null, fn (Builder $query, $id) => $query->where('program_studi_id', $id))
            ->when($filters['status'] ?? null, fn (Builder $query, $status) => $query->where('status', $status))
            ->latest('id')
            ->paginate(10)
            ->withQueryString(); // search, prodi, dan status ikut ke halaman berikutnya.

        return view('admin.mahasiswa.index', [
            'mahasiswa' => $mahasiswa,
            'programStudi' => ProgramStudi::orderBy('nama')->get(),
            'filters' => $filters,
        ]);
    }

    public function create(): View
    {
        return view('admin.mahasiswa.create', [
            'mahasiswa' => new Mahasiswa,
            'programStudi' => ProgramStudi::orderBy('nama')->get(),
        ]);
    }

    public function store(MahasiswaRequest $request): RedirectResponse
    {
        Mahasiswa::create($request->validated());

        return to_route('admin.mahasiswa.index')->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    public function edit(Mahasiswa $mahasiswa): View
    {
        return view('admin.mahasiswa.edit', [
            'mahasiswa' => $mahasiswa,
            'programStudi' => ProgramStudi::orderBy('nama')->get(),
        ]);
    }

    public function update(MahasiswaRequest $request, Mahasiswa $mahasiswa): RedirectResponse
    {
        $mahasiswa->update($request->validated());

        return to_route('admin.mahasiswa.index')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy(Request $request, Mahasiswa $mahasiswa): RedirectResponse
    {
        // Permission saja tidak cukup: wajib hanya memiliki role Admin (Admin murni).
        // Staf dengan permission hapus langsung pun tetap ditolak.
        abort_unless($request->user()?->hasExactRoles(['Admin']), 403, 'Hanya Admin yang boleh menghapus data.');

        $mahasiswa->delete();

        return to_route('admin.mahasiswa.index')->with('success', 'Data mahasiswa berhasil dihapus.');
    }
}

<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;

class AcademicSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Teknik Informatika', 'Sistem Informasi', 'Teknologi Informasi', 'Teknik Komputer'] as $nama) {
            $programStudi = ProgramStudi::firstOrCreate(['nama' => $nama]);

            // Seeder boleh diulang: hanya isi prodi yang belum memiliki mahasiswa.
            if (! $programStudi->mahasiswa()->exists()) {
                Mahasiswa::factory()->count(15)->create([
                    'program_studi_id' => $programStudi->id,
                ]);
            }
        }
    }
}

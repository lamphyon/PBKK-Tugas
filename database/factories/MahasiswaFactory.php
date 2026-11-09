<?php

namespace Database\Factories;

use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Mahasiswa> */
class MahasiswaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nrp' => fake()->unique()->numerify('5025######'),
            'nama' => fake('id_ID')->name(),
            'email' => fake()->unique()->safeEmail(),
            'program_studi_id' => ProgramStudi::factory(),
            'angkatan' => fake()->numberBetween(now()->year - 4, now()->year),
            'status' => fake()->randomElement(['Aktif', 'Aktif', 'Aktif', 'Cuti', 'Lulus']),
        ];
    }
}

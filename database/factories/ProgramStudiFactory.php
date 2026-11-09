<?php

namespace Database\Factories;

use App\Models\ProgramStudi;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<ProgramStudi> */
class ProgramStudiFactory extends Factory
{
    public function definition(): array
    {
        return ['nama' => 'Program Studi '.fake()->unique()->word()];
    }
}

<?php

namespace App\Models;

use Database\Factories\ProgramStudiFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProgramStudi extends Model
{
    /** @use HasFactory<ProgramStudiFactory> */
    use HasFactory;

    protected $table = 'program_studi';

    protected $fillable = ['nama'];

    /** @return HasMany<Mahasiswa, $this> */
    public function mahasiswa(): HasMany
    {
        return $this->hasMany(Mahasiswa::class);
    }
}

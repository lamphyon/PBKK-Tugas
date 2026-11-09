<?php

namespace App\Models;

use Database\Factories\MahasiswaFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mahasiswa extends Model
{
    /** @use HasFactory<MahasiswaFactory> */
    use HasFactory;

    protected $table = 'mahasiswa';

    protected $fillable = [
        'nrp', 'nama', 'email', 'program_studi_id', 'angkatan', 'status',
    ];

    /** @return BelongsTo<ProgramStudi, $this> */
    public function programStudi(): BelongsTo
    {
        return $this->belongsTo(ProgramStudi::class);
    }
}

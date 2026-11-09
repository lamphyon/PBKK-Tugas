<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('program_studi', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
            $table->timestamps();
        });

        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->string('nrp', 10)->unique();
            $table->string('nama', 100);
            $table->string('email')->unique();
            $table->foreignId('program_studi_id')->constrained('program_studi')->restrictOnDelete();
            $table->unsignedSmallInteger('angkatan');
            $table->string('status', 20)->default('Aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
        Schema::dropIfExists('program_studi');
    }
};

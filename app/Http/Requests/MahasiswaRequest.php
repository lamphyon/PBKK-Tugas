<?php

namespace App\Http\Requests;

use App\Models\Mahasiswa;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MahasiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Otorisasi aksi telah diperiksa oleh permission middleware controller.
        return true;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        $mahasiswa = $this->route('mahasiswa');
        $id = $mahasiswa instanceof Mahasiswa ? $mahasiswa->id : null;

        return [
            'nrp' => ['required', 'digits:10', Rule::unique('mahasiswa', 'nrp')->ignore($id)],
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', Rule::unique('mahasiswa', 'email')->ignore($id)],
            'program_studi_id' => ['required', 'integer', 'exists:program_studi,id'],
            'angkatan' => ['required', 'integer', 'min:2000', 'max:'.now()->year],
            'status' => ['required', Rule::in(['Aktif', 'Cuti', 'Lulus'])],
        ];
    }
}

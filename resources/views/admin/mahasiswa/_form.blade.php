{{-- Form dipakai bersama oleh halaman tambah dan ubah. old() menjaga isian saat validasi gagal. --}}
@csrf
<div class="row g-3">
    <div class="col-md-6">
        <label for="nrp" class="form-label">NRP <span class="text-danger">*</span></label>
        <input
            id="nrp" name="nrp"
            value="{{ old('nrp', $mahasiswa->nrp) }}"
            class="form-control @error('nrp') is-invalid @enderror"
            inputmode="numeric" pattern="[0-9]{10}"
            minlength="10" maxlength="10" required
            aria-describedby="nrp-help"
        >
        <div id="nrp-help" class="form-text">Gunakan 10 digit angka.</div>
        @error('nrp')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label for="nama" class="form-label">Nama lengkap <span class="text-danger">*</span></label>
        <input
            id="nama" name="nama"
            value="{{ old('nama', $mahasiswa->nama) }}"
            class="form-control @error('nama') is-invalid @enderror"
            maxlength="100" required
        >
        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
        <input
            type="email" id="email" name="email"
            value="{{ old('email', $mahasiswa->email) }}"
            class="form-control @error('email') is-invalid @enderror"
            maxlength="255" required
        >
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label for="program_studi_id" class="form-label">Program studi <span class="text-danger">*</span></label>
        <select id="program_studi_id" name="program_studi_id" class="form-select @error('program_studi_id') is-invalid @enderror" required>
            <option value="">Pilih program studi</option>
            @foreach ($programStudi as $prodi)
                <option value="{{ $prodi->id }}" @selected(old('program_studi_id', $mahasiswa->program_studi_id) == $prodi->id)>{{ $prodi->nama }}</option>
            @endforeach
        </select>
        @error('program_studi_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label for="angkatan" class="form-label">Angkatan <span class="text-danger">*</span></label>
        <input
            type="number" id="angkatan" name="angkatan"
            value="{{ old('angkatan', $mahasiswa->angkatan ?? date('Y')) }}"
            class="form-control @error('angkatan') is-invalid @enderror"
            min="2000" max="{{ date('Y') }}" required
        >
        @error('angkatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label for="status" class="form-label">Status akademik <span class="text-danger">*</span></label>
        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
            @foreach (['Aktif', 'Cuti', 'Lulus'] as $status)
                <option @selected(old('status', $mahasiswa->status ?? 'Aktif') === $status)>{{ $status }}</option>
            @endforeach
        </select>
        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>
<div class="d-flex gap-2 mt-4 pt-3 border-top">
    <button type="submit" class="btn btn-primary">Simpan Data</button>
    <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-outline-secondary">Batal</a>
</div>

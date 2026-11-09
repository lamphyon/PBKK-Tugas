<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach (['lihat dashboard', 'lihat mahasiswa', 'tambah mahasiswa', 'ubah mahasiswa', 'hapus mahasiswa'] as $nama) {
            Permission::findOrCreate($nama, 'web');
        }

        $admin = Role::findOrCreate('Admin', 'web');
        $staf = Role::findOrCreate('Staf', 'web');

        // Relasi role-permission disimpan di database oleh Spatie.
        $admin->syncPermissions(Permission::all());
        $staf->syncPermissions([
            'lihat dashboard', 'lihat mahasiswa', 'tambah mahasiswa', 'ubah mahasiswa',
        ]);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}

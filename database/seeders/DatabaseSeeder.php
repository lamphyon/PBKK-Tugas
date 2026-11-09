<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolePermissionSeeder::class);

        // Akun demo hanya dibuat untuk pengembangan dan evaluasi lokal.
        if (app()->environment(['local', 'testing'])) {
            foreach (['Admin' => 'admin', 'Staf' => 'staf'] as $role => $akun) {
                $user = User::firstOrCreate(
                    ['email' => $akun.'@akademik.test'],
                    [
                        'name' => $role.' Demo',
                        'password' => 'password', // Cast hashed pada User mengenkripsi ini.
                    ],
                );

                if ($user->wasRecentlyCreated) {
                    $user->forceFill(['email_verified_at' => now()])->save();
                }

                $user->syncRoles([$role]);
            }

            $this->call(AcademicSeeder::class);
        }
    }
}

<?php

use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\RolePermissionSeeder;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('guests must log in before accessing the backoffice', function () {
    $this->get('/dashboard')->assertRedirect('/login');
    $this->get('/admin/mahasiswa')->assertRedirect('/login');
    $this->post('/admin/mahasiswa')->assertRedirect('/login');
    $this->delete('/admin/mahasiswa/1')->assertRedirect('/login');
});

test('unverified users must verify email before accessing the backoffice', function () {
    $user = User::factory()->unverified()->create()->assignRole('Admin');
    $this->actingAs($user)->get('/dashboard')->assertRedirect('/verify-email');
    $this->get('/admin/mahasiswa')->assertRedirect('/verify-email');
});

test('a user without permissions cannot access any academic action', function () {
    $mahasiswa = Mahasiswa::factory()->create();
    $this->actingAs(User::factory()->create());

    $this->get('/dashboard')->assertForbidden();
    $this->get('/admin/mahasiswa')->assertForbidden();
    $this->get('/admin/mahasiswa/create')->assertForbidden();
    $this->get('/admin/mahasiswa/'.$mahasiswa->id.'/edit')->assertForbidden();
    $this->post('/admin/mahasiswa')->assertForbidden();
    $this->put('/admin/mahasiswa/'.$mahasiswa->id)->assertForbidden();
    $this->delete('/admin/mahasiswa/'.$mahasiswa->id)->assertForbidden();
});

test('dashboard statistics reflect the database for both roles', function (string $role) {
    $user = User::factory()->create()->assignRole($role);
    Mahasiswa::factory()->count(3)->create();

    $this->actingAs($user)->get('/dashboard')
        ->assertOk()
        ->assertViewHas('totalMahasiswa', 3)
        ->assertViewHas('totalProgramStudi', ProgramStudi::count())
        ->assertViewHas('totalPengguna', User::count());
})->with(['Admin', 'Staf']);

test('delete buttons are rendered only for an Admin', function () {
    Mahasiswa::factory()->create();
    $staf = User::factory()->create()->assignRole('Staf');
    $admin = User::factory()->create()->assignRole('Admin');

    $this->actingAs($staf)->get('/admin/mahasiswa')->assertOk()->assertDontSee('Hapus Data');
    $this->actingAs($admin)->get('/admin/mahasiswa')->assertOk()->assertSee('Hapus Data');
});

test('staff cannot delete by calling the URL directly', function () {
    $mahasiswa = Mahasiswa::factory()->create();
    $staf = User::factory()->create()->assignRole('Staf');

    $this->actingAs($staf)->delete('/admin/mahasiswa/'.$mahasiswa->id)->assertForbidden();
    $this->assertModelExists($mahasiswa);
});

test('giving staff delete permission still does not bypass the Admin role check', function () {
    $mahasiswa = Mahasiswa::factory()->create();
    $staf = User::factory()->create()->assignRole('Staf');
    $staf->givePermissionTo('hapus mahasiswa');

    $this->actingAs($staf)->get('/admin/mahasiswa')->assertDontSee('Hapus Data');
    $this->delete('/admin/mahasiswa/'.$mahasiswa->id)->assertForbidden();
    $this->assertModelExists($mahasiswa);
});

test('mixed Admin and Staf roles do not qualify as Admin murni', function () {
    $mahasiswa = Mahasiswa::factory()->create();
    $user = User::factory()->create()->assignRole(['Admin', 'Staf']);

    $this->actingAs($user)->get('/admin/mahasiswa')->assertDontSee('Hapus Data');
    $this->delete('/admin/mahasiswa/'.$mahasiswa->id)->assertForbidden();
    $this->assertModelExists($mahasiswa);
});

test('an Admin can delete a mahasiswa', function () {
    $mahasiswa = Mahasiswa::factory()->create();
    $admin = User::factory()->create()->assignRole('Admin');

    $this->actingAs($admin)->delete('/admin/mahasiswa/'.$mahasiswa->id)
        ->assertRedirect(route('admin.mahasiswa.index'));
    $this->assertModelMissing($mahasiswa);
});

test('an Admin also loses delete access when its database permission is revoked', function () {
    $mahasiswa = Mahasiswa::factory()->create();
    $admin = User::factory()->create()->assignRole('Admin');
    Role::findByName('Admin')->revokePermissionTo('hapus mahasiswa');

    $this->actingAs($admin)->get('/admin/mahasiswa')->assertDontSee('Hapus Data');
    $this->delete('/admin/mahasiswa/'.$mahasiswa->id)->assertForbidden();
    $this->assertModelExists($mahasiswa);
});

test('seeding twice preserves the demo accounts and sixty students', function () {
    $this->seed(DatabaseSeeder::class);
    $this->seed(DatabaseSeeder::class);

    $this->assertDatabaseCount('mahasiswa', 60);
    $this->assertDatabaseCount('program_studi', 4);
    $this->assertDatabaseCount('users', 2);
    expect(User::where('email', 'admin@akademik.test')->first()->hasVerifiedEmail())->toBeTrue();
});

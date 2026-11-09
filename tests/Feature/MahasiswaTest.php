<?php

use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('Admin and Staf can create and update students', function (string $role) {
    $user = User::factory()->create()->assignRole($role);
    $prodi = ProgramStudi::factory()->create();
    $data = [
        'nrp' => '5025241092',
        'nama' => 'Sultan Barizy',
        'email' => 'sultan@example.com',
        'program_studi_id' => $prodi->id,
        'angkatan' => 2024,
        'status' => 'Aktif',
    ];

    $this->actingAs($user)->get('/admin/mahasiswa/create')->assertOk();
    $this->post('/admin/mahasiswa', $data)->assertRedirect(route('admin.mahasiswa.index'));
    $this->assertDatabaseHas('mahasiswa', $data);

    $mahasiswa = Mahasiswa::firstOrFail();
    $this->get('/admin/mahasiswa/'.$mahasiswa->id.'/edit')->assertOk();
    $data['status'] = 'Cuti';
    $this->put('/admin/mahasiswa/'.$mahasiswa->id, $data)->assertRedirect(route('admin.mahasiswa.index'));
    $this->assertDatabaseHas('mahasiswa', $data);
})->with(['Admin', 'Staf']);

test('invalid fields cannot enter the database', function () {
    $user = User::factory()->create()->assignRole('Staf');

    $this->actingAs($user)->post('/admin/mahasiswa', [
        'nrp' => 'abc',
        'nama' => '',
        'email' => 'bukan-email',
        'program_studi_id' => 999,
        'angkatan' => now()->year + 1,
        'status' => 'Bebas',
    ])->assertSessionHasErrors(['nrp', 'nama', 'email', 'program_studi_id', 'angkatan', 'status']);

    $this->assertDatabaseCount('mahasiswa', 0);
});

test('NRP and email must be unique', function () {
    $user = User::factory()->create()->assignRole('Admin');
    $mahasiswa = Mahasiswa::factory()->create();

    $this->actingAs($user)->post('/admin/mahasiswa', $mahasiswa->only([
        'nrp', 'nama', 'email', 'program_studi_id', 'angkatan', 'status',
    ]))->assertSessionHasErrors(['nrp', 'email']);
});

test('search and filters stay combined and persist on the next page', function () {
    $user = User::factory()->create()->assignRole('Staf');
    $prodi = ProgramStudi::factory()->create();
    Mahasiswa::factory()->count(12)->create([
        'nama' => 'Andi Mahasiswa', 'program_studi_id' => $prodi->id, 'status' => 'Aktif',
    ]);
    Mahasiswa::factory()->create(['nama' => 'Andi Cuti', 'program_studi_id' => $prodi->id, 'status' => 'Cuti']);
    Mahasiswa::factory()->create(['nama' => 'Andi Prodi Lain', 'status' => 'Aktif']);

    $filters = ['search' => 'Andi', 'program_studi_id' => $prodi->id, 'status' => 'Aktif'];
    $response = $this->actingAs($user)->get('/admin/mahasiswa?'.http_build_query($filters));
    $response->assertOk()->assertDontSee('Andi Cuti')->assertDontSee('Andi Prodi Lain');

    $paginator = $response->viewData('mahasiswa');
    expect($paginator->total())->toBe(12);
    parse_str(parse_url($paginator->nextPageUrl(), PHP_URL_QUERY), $nextQuery);
    expect($nextQuery)->toMatchArray($filters);

    $this->get($paginator->nextPageUrl())->assertOk()->assertViewHas('mahasiswa', fn ($page) => $page->count() === 2);
});

test('empty search results display a useful message', function () {
    $user = User::factory()->create()->assignRole('Staf');
    $this->actingAs($user)->get('/admin/mahasiswa?search=tidakada')
        ->assertOk()->assertSee('Tidak ada mahasiswa yang sesuai.');
});

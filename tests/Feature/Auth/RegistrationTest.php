<?php

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
    expect(User::where('email', 'test@example.com')->first()->hasExactRoles(['Staf']))->toBeTrue();
});

test('registration cannot choose an admin role or skip email verification', function () {
    $this->post('/register', [
        'name' => 'Calon Staf',
        'email' => 'staf-baru@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'role' => 'Admin',
        'email_verified_at' => now(),
    ])->assertRedirect('/dashboard');

    $user = User::where('email', 'staf-baru@example.com')->firstOrFail();
    expect($user->hasExactRoles(['Staf']))->toBeTrue();
    expect($user->hasVerifiedEmail())->toBeFalse();
    $this->get('/dashboard')->assertRedirect(route('verification.notice'));
});

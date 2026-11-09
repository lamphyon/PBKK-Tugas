<?php

use App\Models\User;
use Database\Seeders\DatabaseSeeder;

beforeEach(function () {
    config(['demo.login_enabled' => true]);
    $this->seed(DatabaseSeeder::class);
});

test('both demo buttons log in to the intended account', function (string $account) {
    $this->get('/login')->assertOk()->assertSee('Masuk Admin')->assertSee('Masuk Staf');
    $this->post('/demo-login/'.$account)->assertRedirect('/dashboard');
    $this->assertAuthenticatedAs(User::where('email', $account.'@akademik.test')->firstOrFail());
    $this->get('/dashboard')->assertOk();
})->with(['admin', 'staf']);

test('demo login can be disabled', function () {
    config(['demo.login_enabled' => false]);
    $this->get('/login')->assertDontSee('Masuk Admin')->assertDontSee('Masuk Staf');
    $this->post('/demo-login/admin')->assertNotFound();
    $this->assertGuest();
});

test('demo login is always blocked in production', function () {
    $this->app->instance('env', 'production');
    $this->get('/login')->assertDontSee('Masuk Admin');
    // Di production CSRF aktif; kirim token valid agar pengunci environment diuji.
    $this->post('/demo-login/admin', ['_token' => session('_token')])->assertNotFound();
    $this->assertGuest();
});

test('demo login cannot select arbitrary users', function () {
    $this->post('/demo-login/unknown')->assertNotFound();
    $this->assertGuest();
});

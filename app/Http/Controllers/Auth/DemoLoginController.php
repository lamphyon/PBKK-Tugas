<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DemoLoginController extends Controller
{
    public function __invoke(Request $request, string $account): RedirectResponse
    {
        abort_unless(
            app()->environment(['local', 'testing']) && config('demo.login_enabled'),
            404,
        );

        $email = config('demo.accounts.'.$account);
        abort_unless(is_string($email), 404);

        $user = User::where('email', $email)->firstOrFail();
        $role = $account === 'admin' ? 'Admin' : 'Staf';
        abort_unless($user->hasExactRoles([$role]) && $user->hasVerifiedEmail(), 403);

        Auth::login($user);
        $request->session()->regenerate();

        return to_route('dashboard');
    }
}

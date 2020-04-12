<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Support\Arr;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login()
    {
        return Socialite::driver('passport')->redirect();
    }

    public function loginCallback()
    {
        $socialiteUser = Socialite::driver('passport')->user();

        $user = User::unguarded(function () use ($socialiteUser) {
            return tap(User::firstOrNew(['provider_uid' => $socialiteUser->id])
                ->fill([
                    'name' => $socialiteUser->name,
                    'email' => $socialiteUser->email,
                    'email_verified_at' => Arr::get($socialiteUser->getRaw(), 'email_verified_at'),
                ]))->save();
        });

        auth()->login($user);

        session()->regenerate();

        session([
            'token' => $socialiteUser->token,
            'refresh_token' => $socialiteUser->refreshToken,
            'expires_at' => now()->addSeconds($socialiteUser->expiresIn),
        ]);


        return redirect()->intended($this->redirectTo);
    }

    public function logout()
    {
        auth()->logout();

        session()->invalidate();

        return redirect('/');
    }
}

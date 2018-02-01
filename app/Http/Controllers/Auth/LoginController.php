<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Socialite;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')
            ->scopes(['read:user', 'public_repo'])
            ->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        try {
            $github_user = Socialite::driver('github')->user();

            $user = User::firstOrNew(['email' => $github_user->email]);
            $user->name = $github_user->name;
            $user->token = $github_user->token;
            $user->nickname = $github_user->nickname;
            $user->save();

            auth()->login($user, true);
        } catch (\Exception $e) {
            abort(500);
        }

        return redirect()->route('issues');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        auth()->guard()->logout();

        request()->session()->invalidate();

        return redirect()->route('index');
    }
}

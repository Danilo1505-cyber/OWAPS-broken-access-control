<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Support\SaltedPassword;
use Laravel\Fortify\Http\Requests\LoginRequest;

class AuthenticateUser
{
    public function __invoke(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! SaltedPassword::check($user, $credentials['password'])) {
            return null;
        }

        // Utente vecchio con password corretta → lo migro
        if ((int) $user->hash_version !== 2) {
            $user->forceFill(SaltedPassword::make($credentials['password']))->save();
        }

        return $user;
    }
}
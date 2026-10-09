<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SaltedPassword
{
    // Crea i campi da salvare per una nuova password
    public static function make(string $password): array
    {
        $salt = Str::random(32);

        return [
            'password'     => Hash::make($password . $salt . config('app.pepper')),
            'salt'         => $salt,
            'hash_version' => 2,
        ];
    }

    // Verifica una password, sia per utenti nuovi che vecchi
    public static function check(User $user, string $password): bool
    {
        if ((int) $user->hash_version === 2) {
            return Hash::check($password . $user->salt . config('app.pepper'), $user->password);
        }

        return Hash::check($password, $user->password);
    }
}
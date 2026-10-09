<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Support\SaltedPassword;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class UpdateUserPassword implements UpdatesUserPasswords
{
    use PasswordValidationRules;

    /**
     * Validate and update the user's password.
     *
     * @param  array<string, string>  $input
     */
    public function update(User $user, array $input): void
{
    Validator::make($input, [
        'current_password' => ['required', 'string', function ($attribute, $value, $fail) use ($user) {
            if (! SaltedPassword::check($user, $value)) {
                $fail(__('The provided password does not match your current password.'));
            }
        }],
        'password' => $this->passwordRules(),
    ])->validateWithBag('updatePassword');

    $user->forceFill(SaltedPassword::make($input['password']))->save();
}
}

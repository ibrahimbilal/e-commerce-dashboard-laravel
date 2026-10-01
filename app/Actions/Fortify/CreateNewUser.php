<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * @param  array<string, mixed>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'email' => [
                'required',
                'string',
                'email',
                'max:50',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'mobile' => ['nullable', 'string', 'max:20'],
            'profile_picture' => ['nullable', 'string', 'max:191'],
        ])->validate();

        $user = User::create([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'mobile' => $input['mobile'] ?? null,
            'profile_picture' => $input['profile_picture'] ?? null,
        ]);

        $user->markEmailAsVerified();

        return $user;
    }
}

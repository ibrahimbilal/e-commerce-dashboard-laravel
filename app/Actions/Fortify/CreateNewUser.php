<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Spatie\Permission\Models\Role;

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
            'roles' => ['nullable', 'array'],
            'roles.*' => ['string', Rule::exists('roles', 'name')->where('guard_name', 'web')],
            'role_name' => ['nullable', 'string', Rule::exists('roles', 'name')->where('guard_name', 'web')],
        ])->validate();

        $user = User::create([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'mobile' => $input['mobile'] ?? null,
            'profile_picture' => $input['profile_picture'] ?? null,
            'email_verified_at' => now(),
        ]);

        $roleNames = $input['roles'] ?? [];
        if (! empty($input['role_name'])) {
            $roleNames[] = $input['role_name'];
        }

        if ($roleNames !== []) {
            $user->syncRoles(array_values(array_unique($roleNames)));
        }

        return $user;
    }
}

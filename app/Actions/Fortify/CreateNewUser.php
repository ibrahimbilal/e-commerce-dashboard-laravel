<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
		Validator::make($input, [
            'first_name' => ['required', 'string', 'max:255'],
			'last_name'	=> ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
			'mobile' => ['nullable', 'numeric', 'digits_between:9,15'],
			'birth_date' => [
				'nullable',
				'date',
				'date_format:Y-m-d',
				'before_or_equal:' . date("Y-m-d", strtotime('-18 years'))
			],
			'gender' => ['required',Rule::in(['male', 'female'])],
			'role_name' => ['required','numeric', Rule::exists(Role::class, 'id')],
			'language' => ['required','string'],
			'profile_picture' => [
				'nullable',
			],
        ])->validate();

        return User::create([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'mobile' => $input['mobile'],
            'birth_date' => $input['birth_date'],
            'gender' => $input['gender'],
            'role_name' => $input['role_name'],
            'language' => $input['language'],
            'profile_picture' => $input['profile_picture'],
        ]);
    }
}

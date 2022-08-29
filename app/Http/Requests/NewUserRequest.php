<?php

namespace App\Http\Requests;

use App\Models\Role;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use App\Http\Traits\UploadFilesTraits;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class NewUserRequest extends FormRequest
{
	use UploadFilesTraits;

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, mixed>
	 */
	public function rules()
	{
		return [
			'first_name' => ['required', 'string', 'max:255'],
			'last_name'	=> ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => ['required', 'string', Password::min(8)],
			'mobile' => ['nullable', 'numeric', 'digits_between:9,15'],
			'birth_date' => [
				'nullable',
				'date',
				'date_format:Y-m-d',
				'before_or_equal:' . date("Y-m-d", strtotime('-18 years'))
			],
			'gender' => ['required',Rule::in(['male', 'female'])],
			'role_id' => ['required','numeric', Rule::exists(Role::class, 'id')],
			'language' => ['required','string'],
			'profile_picture' => [
				File::image()
					->types(['jpeg', 'jpg', 'png'])
					->max(1024)
					->dimensions(Rule::dimensions()->maxWidth(500)->maxHeight(500)->ratio(1)),
			],
		];
	}

	/**
	 * Get the error messages for the defined validation rules.
	 *
	 * @return array
	 */
	public function messages()
	{
		return [
			//
		];
	}


	/**
	 * Get custom attributes for validator errors.
	 *
	 * @return array
	 */
	public function attributes()
	{
		return [
			//
		];
	}
}

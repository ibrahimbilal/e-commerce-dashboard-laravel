<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
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
				'required', 'string', 'email', 'max:255',
				Rule::unique(User::class, 'id')->ignore($this->user()->id),
			],
			'current_password' 	=> ['nullable', 'current_password:web', 'required_with:password'],
			'password' => [
				'nullable', 'string', 'confirmed', 'required_with:current_password',
				'different:current_password', Password::min(8)
			],
			'mobile' => ['nullable', 'numeric', 'digits_between:9,15'],
			'birth_date' => ['nullable', 'date', 'date_format:Y-m-d', 'before_or_equal:' . date("Y-m-d", strtotime('-18 years'))],
			'gender' => ['required', Rule::in(['male', 'female'])],
			'language' => ['required', 'string'],
			'profile_picture' => [
				File::image()
					->types(['jpeg', 'jpg', 'png'])
					->max(1024)
					->dimensions(
						Rule::dimensions()
						->maxWidth(500)
						->maxHeight(500)
						->ratio(1)
					),
			],
		];
    }
}

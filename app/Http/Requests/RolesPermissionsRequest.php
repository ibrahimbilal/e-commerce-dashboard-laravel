<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Http\FormRequest;

class RolesPermissionsRequest extends FormRequest
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
			'role_title' => 'required|string',
			"permissions"    => "array",
			"permissions.*"  => Rule::exists(Permission::class, 'name'),
        ];
    }
}

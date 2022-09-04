<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveSettingsRequest extends FormRequest
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
            'site_title' 			=> 'required|string|min:4',
            'tagline' 				=> 'required|string',
            'site_description' 		=> 'required|string',
            'site_url' 				=> 'required|url',
            'timezone' 				=> 'required|string|timezone',
            'date_formate' 			=> 'required|string',
            'date_formate_custom' 	=> 'required_if:date_formate,custom|string',
            'time_formate' 			=> 'required|string',
            'time_formate_custom' 	=> 'required_if:time_formate,custom|string',
        ];
    }
}

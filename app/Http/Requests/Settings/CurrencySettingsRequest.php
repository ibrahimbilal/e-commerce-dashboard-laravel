<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class CurrencySettingsRequest extends FormRequest
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
            'main_currency'				=> 'required|string|max:3',
            'currency_position'			=> 'required|string',
            'thousand_sep'				=> 'required|string|max:1',
            'decimal_sep'				=> 'required|string|max:1',
            'num_decimals'				=> 'required|numeric|max:10',
            'enable_multi_currencies'	=> 'boolean',
            'currencies_display'		=> 'required_if:enable_multi_currencies,true|string',
            'multi_currencies'			=> 'required_if:enable_multi_currencies,true|array',
        ];
    }
}

<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class StoreSettingsRequest extends FormRequest
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
            'country'				=> 'required|string|max:2',
            'state'					=> 'required|string',
            'city'					=> 'required|string',
            'address_1'				=> 'required|string',
            'address_2'				=> 'sometimes|string|nullable|max:100',
            'postcode'				=> 'required|string|max:10',
            'reviews'				=> 'boolean',
            'guest_reviews'			=> 'boolean',
            'guest_checkout'		=> 'boolean',
            'wishlist'				=> 'boolean',
            'compare'				=> 'boolean',
            'out_of_stock_products'	=> 'boolean',
            'social_share'			=> 'boolean',
            'share_on'				=> 'required_if:social_share,true|array',
            'recently_viewed'		=> 'boolean',
            'recommend'				=> 'boolean',
        ];
    }
}

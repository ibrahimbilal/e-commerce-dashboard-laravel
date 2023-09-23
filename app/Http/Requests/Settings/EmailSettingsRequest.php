<?php

namespace App\Http\Requests\Settings;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EmailSettingsRequest extends FormRequest
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
            'email_from_name'					=> 'required|string|min:4',
            'email_from_address'				=> 'required|email',

            'email_main_color'					=> ['required', 'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
            'email_bg_color'					=> ['required', 'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
            'email_body_bg_color'				=> ['required', 'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
            'email_text_color'					=> ['required', 'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],

            'email_new_order'					=> 'boolean',
            'new_order_recipients_type'			=> [
													'required_if:email_new_order,true',
													'string',
													Rule::in(['custom', 'recipients-role'])
												],
            'new_order_recipients'				=> 'required_if:email_new_order,true|array',

            'email_out_of_stock'				=> 'boolean',
            'out_of_stock_recipients_type'		=> [
													'required_if:email_out_of_stock,true',
													'string',
													Rule::in(['custom', 'recipients-role'])
												],
            'out_of_stock_recipients'			=> 'required_if:email_out_of_stock,true|array',

            'email_order_canceled'				=> 'boolean',
            'order_canceled_recipients_type'	=> [
													'required_if:email_order_canceled,true',
													'string',
													Rule::in(['custom', 'recipients-role'])
												],
            'order_canceled_recipients'			=> 'required_if:email_order_canceled,true|array',

            'email_order_confirmed'				=> 'boolean',
            'email_order_shipped'				=> 'boolean',
            'email_order_completed'				=> 'boolean',
            'email_order_refunded'				=> 'boolean',
        ];
    }
}

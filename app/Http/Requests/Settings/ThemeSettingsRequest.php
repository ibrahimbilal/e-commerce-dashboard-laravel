<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class ThemeSettingsRequest extends FormRequest
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
            'logo_width'			=> 'required|numeric|min:0|max:300',
            'logo_height'			=> 'required|numeric|min:0|max:300',
            'mobile_logo_width'		=> 'required|numeric|min:0|max:300',

            'main_color'			=> ['required', 'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
            'main_color_hover'		=> ['required', 'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
            'box_bg_color'			=> ['required', 'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
            'body_background'		=> ['required', 'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
            'menu_badge_bg'			=> ['required', 'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
            'menu_active_bg'		=> ['required', 'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
            'text_color'			=> ['required', 'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],

            'dark_main_color'		=> ['required', 'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
            'dark_main_color_hover'	=> ['required', 'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
            'dark_box_bg_color'		=> ['required', 'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
            'dark_body_background'	=> ['required', 'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
            'dark_menu_badge_bg'	=> ['required', 'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
            'dark_menu_active_bg'	=> ['required', 'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
            'dark_text_color'		=> ['required', 'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i']
        ];
    }
}

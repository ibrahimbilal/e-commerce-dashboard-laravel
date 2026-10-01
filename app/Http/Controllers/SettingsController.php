<?php

namespace App\Http\Controllers;

use App\Models\Option;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $options = Option::orderBy('option_key')->get();

        return view('settings.general', compact('options'));
    }

    public function theme()
    {
        return view('settings.theme');
    }

    public function store()
    {
        return view('settings.store');
    }

    public function currencies()
    {
        return view('settings.currencies');
    }

    public function emails()
    {
        return view('settings.emails');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'options' => ['required', 'array'],
            'options.*.id' => ['nullable', 'integer', 'exists:options,id'],
            'options.*.option_key' => ['required', 'string', 'max:100'],
            'options.*.option_value' => ['nullable', 'string', 'max:100'],
        ]);

        foreach ($validated['options'] as $row) {
            if (! empty($row['id'])) {
                Option::whereKey($row['id'])->update([
                    'option_key' => $row['option_key'],
                    'option_value' => $row['option_value'] ?? null,
                ]);
            } else {
                Option::create([
                    'option_key' => $row['option_key'],
                    'option_value' => $row['option_value'] ?? null,
                ]);
            }
        }

        return redirect()->route('settings.index')->with('status', 'Settings updated.');
    }
}

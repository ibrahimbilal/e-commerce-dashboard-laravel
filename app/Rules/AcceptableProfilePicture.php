<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\UploadedFile;

class AcceptableProfilePicture implements Rule
{
    public function passes($attribute, $value): bool
    {
        if ($value === null) {
            return true;
        }

        if (! $value instanceof UploadedFile) {
            return false;
        }

        if ($value->getSize() > 1024 * 1024) {
            return false;
        }

        $mime = strtolower((string) $value->getMimeType());
        $allowed = ['image/jpeg', 'image/jpg', 'image/png', 'image/x-png'];

        return in_array($mime, $allowed, true);
    }

    public function message(): string
    {
        return __('validation.mimes', ['attribute' => 'profile picture', 'values' => 'jpg, jpeg, png']);
    }
}

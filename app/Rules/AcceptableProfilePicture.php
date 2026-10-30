<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\UploadedFile;

class AcceptableProfilePicture implements Rule
{
    private bool $tooLarge = false;

    public function passes($attribute, $value): bool
    {
        if ($value === null) {
            return true;
        }

        if (! $value instanceof UploadedFile) {
            return false;
        }

        if ($value->getSize() > 1024 * 1024) {
            $this->tooLarge = true;

            return false;
        }

        $mime = strtolower((string) $value->getMimeType());
        $allowed = ['image/jpeg', 'image/jpg', 'image/png', 'image/x-png'];

        return in_array($mime, $allowed, true);
    }

    public function message(): string
    {
        if ($this->tooLarge) {
            return __('validation.profile_picture_max', ['attribute' => 'profile picture', 'max' => '1 MB']);
        }

        return __('validation.mimes', ['attribute' => 'profile picture', 'values' => 'jpg, jpeg, png']);
    }
}

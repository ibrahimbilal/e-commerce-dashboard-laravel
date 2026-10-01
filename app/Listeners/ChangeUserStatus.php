<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Verified;

class ChangeUserStatus
{
    public function handle(Verified $event): void
    {
        // User model no longer has a status column; verification is tracked via email_verified_at.
    }
}

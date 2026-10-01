<?php

namespace Database\Seeders;

use App\Models\User;
use App\Support\DemoImageGenerator;
use App\Support\StoredMedia;
use Illuminate\Database\Seeder;

class AdminAvatarSeeder extends Seeder
{
    /**
     * Requires `php artisan storage:link` so /storage/avatars/* is web-accessible.
     */
    public function run(): void
    {
        $admin = User::query()->where('email', 'admin@example.com')->first();

        if (! $admin) {
            return;
        }

        $path = DemoImageGenerator::seedAdminAvatar();

        if ($path) {
            $admin->forceFill([
                'profile_picture' => StoredMedia::normalizeStoredPath($path),
            ])->save();
        }
    }
}

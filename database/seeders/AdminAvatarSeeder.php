<?php

namespace Database\Seeders;

use App\Models\User;
use App\Support\DemoImageGenerator;
use App\Support\StoredMedia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

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

        $relative = 'avatars/admin.png';

        if (! Storage::disk('public')->exists($relative)) {
            DemoImageGenerator::writeAdminAvatar();
        }

        if (! Storage::disk('public')->exists($relative)) {
            Storage::disk('public')->makeDirectory('avatars');
            $png = base64_decode(
                'iVBORw0KGgoAAAANSUhEUgAAAAoAAAAKCAYAAACNMs+9AAAAFUlEQVR42mNk+M9Qz0AEYBxVSF+FABJADveWkH6oAAAAAElFTkSuQmCC',
                true
            );
            Storage::disk('public')->put($relative, $png !== false ? $png : '');
        }

        $admin->forceFill([
            'profile_picture' => StoredMedia::databasePath($relative),
        ])->save();
    }
}

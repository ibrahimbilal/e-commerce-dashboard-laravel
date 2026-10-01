<?php

namespace Database\Seeders;

use App\Models\User;
use App\Support\DemoImageGenerator;
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

        $path = DemoImageGenerator::writeAdminAvatar();

        if (! $path) {
            Storage::disk('public')->makeDirectory('avatars');
            $fallback = 'avatars/admin.png';
            if (! Storage::disk('public')->exists($fallback)) {
                $png = base64_decode(
                    'iVBORw0KGgoAAAANSUhEUgAAAAoAAAAKCAYAAACNMs+9AAAAFUlEQVR42mNk+M9Qz0AEYBxVSF+FABJADveWkH6oAAAAAElFTkSuQmCC',
                    true
                );
                Storage::disk('public')->put($fallback, $png !== false ? $png : '');
            }
            $path = 'storage/'.$fallback;
        }

        $admin->forceFill(['profile_picture' => $path])->save();
    }
}

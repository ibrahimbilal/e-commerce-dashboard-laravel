<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use App\Support\ProfilePictureProcessor;
use App\Support\StoredMedia;
use Database\Seeders\LangSeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class ProfilePictureProcessingTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        $this->seed([PermissionsSeeder::class, LangSeeder::class, RoleSeeder::class, UserSeeder::class]);
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        $this->admin = User::query()->where('email', 'admin@example.com')->firstOrFail();
    }

    /**
     * @return array<string, mixed>
     */
    private function userStorePayload(array $overrides = []): array
    {
        return array_merge([
            'first_name' => 'Pic',
            'last_name' => 'User',
            'email' => 'picuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'gender' => 'male',
            'role_name' => 'viewer',
            'language' => 'en',
        ], $overrides);
    }

    /**
     * @return array<string, mixed>
     */
    private function userUpdatePayload(User $user, array $overrides = []): array
    {
        return array_merge([
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'gender' => $user->gender,
            'role_name' => $user->role_name,
            'status' => $user->status,
            'language' => $user->language,
        ], $overrides);
    }

    /**
     * @return array<string, mixed>
     */
    private function customerPayload(array $overrides = []): array
    {
        return array_merge([
            'email' => 'buyer@example.com',
            'password' => 'password123',
            'first_name' => 'Buyer',
            'last_name' => 'One',
            'gender' => 'Male',
        ], $overrides);
    }

    private function assertStoredProfilePictureIs256(string $storedPath): void
    {
        $this->assertMatchesRegularExpression('#^storage/(users|customers)/.+\.(jpe?g|png)$#', $storedPath);

        $relative = StoredMedia::publicDiskRelativePath($storedPath);
        $this->assertNotNull($relative);
        Storage::disk('public')->assertExists($relative);

        $absolute = Storage::disk('public')->path($relative);
        [$width, $height] = getimagesize($absolute);
        $this->assertSame(ProfilePictureProcessor::SIZE, $width);
        $this->assertSame(ProfilePictureProcessor::SIZE, $height);
    }

    public function test_admin_user_update_with_file_stores_storage_path_not_json_blob(): void
    {
        $target = User::factory()->create([
            'email' => 'updatetarget@example.com',
            'role_name' => 'viewer',
        ]);
        $target->assignRole('viewer');

        $file = UploadedFile::fake()->image('avatar.jpg', 400, 400);

        $this->actingAs($this->admin)
            ->post(route('users.update', $target->getKey()), array_merge(
                $this->userUpdatePayload($target),
                ['_method' => 'PATCH', 'profile_picture' => $file]
            ), [
                'Accept' => 'application/json',
            ])
            ->assertOk();

        $target->refresh();

        $this->assertStoredProfilePictureIs256($target->profile_picture);
        $this->assertStringNotContainsString('"path"', (string) $target->profile_picture);
        $this->assertStringNotContainsString('{', (string) $target->profile_picture);
    }

    public function test_user_store_processes_jpeg_to_256_square(): void
    {
        $file = UploadedFile::fake()->image('new.jpg', 400, 400);

        $this->actingAs($this->admin)->post(route('users.store'), array_merge(
            $this->userStorePayload(),
            ['profile_picture' => $file]
        ), [
            'Accept' => 'application/json',
        ])->assertOk();

        $user = User::query()->where('email', 'picuser@example.com')->firstOrFail();
        $this->assertStoredProfilePictureIs256($user->profile_picture);
    }

    public function test_user_store_processes_png_to_256_square(): void
    {
        $file = UploadedFile::fake()->createWithContent('photo.png', $this->minimalPng(300, 300));

        $this->actingAs($this->admin)->post(route('users.store'), array_merge(
            $this->userStorePayload(['email' => 'pnguser@example.com']),
            ['profile_picture' => $file]
        ), [
            'Accept' => 'application/json',
        ])->assertOk();

        $user = User::query()->where('email', 'pnguser@example.com')->firstOrFail();
        $this->assertStoredProfilePictureIs256($user->profile_picture);
        $this->assertStringEndsWith('.png', $user->profile_picture);
    }

    public function test_profile_update_processes_upload_to_256(): void
    {
        $file = UploadedFile::fake()->image('me.jpg', 256, 256);

        $this->actingAs($this->admin)->post(route('users.update_profile'), array_merge(
            $this->userUpdatePayload($this->admin),
            ['profile_picture' => $file]
        ), [
            'Accept' => 'application/json',
        ])->assertOk();

        $this->admin->refresh();
        $this->assertStoredProfilePictureIs256($this->admin->profile_picture);
    }

    public function test_user_store_rejects_non_square_profile_picture(): void
    {
        $file = UploadedFile::fake()->image('wide.jpg', 800, 600);

        $this->actingAs($this->admin)->postJson(route('users.store'), array_merge(
            $this->userStorePayload(['email' => 'nonsquare@example.com']),
            ['profile_picture' => $file]
        ))->assertUnprocessable()->assertJsonValidationErrors(['profile_picture']);
    }

    public function test_user_store_rejects_non_image_profile_picture(): void
    {
        $file = UploadedFile::fake()->create('doc.pdf', 100, 'application/pdf');

        $this->actingAs($this->admin)->postJson(route('users.store'), array_merge(
            $this->userStorePayload(),
            ['profile_picture' => $file]
        ))->assertUnprocessable()->assertJsonValidationErrors(['profile_picture']);
    }

    public function test_user_update_rejects_gif_profile_picture(): void
    {
        $target = User::factory()->create(['role_name' => 'viewer']);
        $target->assignRole('viewer');
        $file = UploadedFile::fake()->create('anim.gif', 100, 'image/gif');

        $this->actingAs($this->admin)->postJson(route('users.update', $target->getKey()), array_merge(
            $this->userUpdatePayload($target),
            ['_method' => 'PATCH', 'profile_picture' => $file]
        ))->assertUnprocessable()->assertJsonValidationErrors(['profile_picture']);
    }

    public function test_customer_store_uploads_and_stores_256_jpeg(): void
    {
        $file = UploadedFile::fake()->image('cust.jpg', 800, 600);

        $this->actingAs($this->admin)->post(route('admin.customers.store'), array_merge(
            $this->customerPayload(),
            ['profile_picture' => $file]
        ), [
            'Accept' => 'application/json',
        ])->assertOk();

        $customer = Customer::query()->where('email', 'buyer@example.com')->firstOrFail();
        $this->assertStoredProfilePictureIs256($customer->profile_picture);
    }

    public function test_customer_update_uploads_png_and_remove_pp_clears_picture(): void
    {
        $customer = Customer::query()->create([
            'email' => 'existing@example.com',
            'password' => bcrypt('password123'),
            'first_name' => 'Ex',
            'last_name' => 'isting',
        ]);
        $customer->update([
            'profile_picture' => StoredMedia::databasePath(
                ProfilePictureProcessor::store(
                    UploadedFile::fake()->image('seed.jpg', 400, 400),
                    'customers'
                )
            ),
        ]);

        $file = UploadedFile::fake()->createWithContent('new.png', $this->minimalPng(700, 700));

        $this->actingAs($this->admin)->post(route('admin.customers.update', $customer), array_merge(
            $this->customerPayload([
                'email' => 'existing@example.com',
            ]),
            ['_method' => 'PUT', 'profile_picture' => $file]
        ), [
            'Accept' => 'application/json',
        ])->assertOk();

        $customer->refresh();
        $this->assertStoredProfilePictureIs256($customer->profile_picture);

        $this->actingAs($this->admin)->putJson(route('admin.customers.update', $customer), array_merge(
            $this->customerPayload([
                'email' => 'existing@example.com',
            ]),
            ['remove_pp' => true]
        ))->assertOk();

        $customer->refresh();
        $this->assertNull($customer->profile_picture);
    }

    public function test_customer_update_keeps_existing_string_path_when_no_new_file(): void
    {
        $path = StoredMedia::databasePath('customers/legacy.jpg');
        $legacy = UploadedFile::fake()->image('legacy.jpg', 256, 256);
        Storage::disk('public')->put('customers/legacy.jpg', file_get_contents($legacy->getRealPath()));

        $customer = Customer::query()->create([
            'email' => 'legacy@example.com',
            'password' => bcrypt('password123'),
            'profile_picture' => $path,
        ]);

        $this->actingAs($this->admin)->putJson(route('admin.customers.update', $customer), [
            'email' => 'legacy@example.com',
            'first_name' => 'Legacy',
            'profile_picture' => $path,
        ])->assertOk();

        $customer->refresh();
        $this->assertSame($path, $customer->profile_picture);
    }

    private function minimalPng(int $width, int $height): string
    {
        $image = imagecreatetruecolor($width, $height);
        ob_start();
        imagepng($image);
        $contents = ob_get_clean();
        imagedestroy($image);

        return $contents ?: '';
    }
}

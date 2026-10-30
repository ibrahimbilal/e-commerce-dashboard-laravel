<?php

namespace Tests\Feature;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\Customer;
use App\Models\Subscriber;
use App\Models\User;
use App\Rules\AcceptableProfilePicture;
use App\Support\OwnedProfilePicture;
use Database\Seeders\LangSeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class TeamyR9FixesTest extends TestCase
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

    private function ajaxHeaders(): array
    {
        return ['Accept' => 'application/json', 'X-Requested-With' => 'XMLHttpRequest'];
    }

    private function putFile(string $relative): string
    {
        Storage::disk('public')->put($relative, 'old');

        return 'storage/'.$relative;
    }

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

    private function customerUpdatePayload(Customer $customer, array $overrides = []): array
    {
        return array_merge(['_method' => 'PUT', 'email' => $customer->email], $overrides);
    }

    private function makeCustomer(?string $picture): Customer
    {
        return Customer::query()->create([
            'email' => 'r9-'.uniqid().'@example.com',
            'password' => bcrypt('password123'),
            'profile_picture' => $picture,
        ]);
    }

    // 1. Marketing destroy returns JSON
    public function test_marketing_destroy_returns_json_with_counts(): void
    {
        $subscriber = Subscriber::query()->create(['email' => 'sub@example.com', 'is_subscriber' => true]);

        $this->actingAs($this->admin)
            ->deleteJson(route('admin.marketing.subscribers.destroy', $subscriber), [], $this->ajaxHeaders())
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('counts.all', 0)
            ->assertJsonStructure(['message', 'counts' => ['all', 'subscribers', 'not_subscribers']]);

        $this->assertDatabaseMissing('subscribers_list', ['id' => $subscriber->id]);
    }

    public function test_marketing_destroy_without_ajax_still_redirects(): void
    {
        $subscriber = Subscriber::query()->create(['email' => 'sub2@example.com', 'is_subscriber' => false]);

        $this->actingAs($this->admin)
            ->delete(route('admin.marketing.subscribers.destroy', $subscriber))
            ->assertRedirect(route('admin.marketing.index'));
    }

    // 2. Factory birth dates are adult and pass UpdateProfileRequest
    public function test_user_factory_birth_dates_are_between_18_and_70_years_ago(): void
    {
        $request = new UpdateProfileRequest();
        $request->setUserResolver(fn () => $this->admin);
        $rule = $request->rules()['birth_date'];

        for ($i = 0; $i < 200; $i++) {
            $birth = User::factory()->make()->birth_date;
            if ($birth === null) {
                continue;
            }
            $date = $birth instanceof \DateTimeInterface ? $birth->format('Y-m-d') : (string) $birth;
            $this->assertLessThanOrEqual(now()->subYears(18)->format('Y-m-d'), $date);
            $this->assertGreaterThanOrEqual(now()->subYears(70)->subDay()->format('Y-m-d'), $date);
            $this->assertTrue(Validator::make(['birth_date' => $date], ['birth_date' => $rule])->passes(), $date);
        }
    }

    // 3. Customer profile_picture strings
    public function test_customer_store_rejects_arbitrary_profile_picture_strings(): void
    {
        foreach (['http://evil/x.png', '../../.env', 'storage/customers/other.jpg'] as $value) {
            $this->actingAs($this->admin)->postJson(route('admin.customers.store'), [
                'email' => 'new-'.md5($value).'@example.com',
                'password' => 'password123',
                'profile_picture' => $value,
            ])->assertStatus(422)->assertJsonValidationErrors('profile_picture');
        }
    }

    public function test_customer_update_rejects_strings_other_than_current_path(): void
    {
        $customer = $this->makeCustomer($this->putFile('customers/mine.jpg'));

        foreach (['http://evil/x.png', '../../.env', 'storage/customers/someone-else.jpg'] as $value) {
            $this->actingAs($this->admin)->postJson(
                route('admin.customers.update', $customer),
                $this->customerUpdatePayload($customer, ['profile_picture' => $value])
            )->assertStatus(422)->assertJsonValidationErrors('profile_picture');
        }

        $this->assertSame('storage/customers/mine.jpg', $customer->fresh()->profile_picture);
    }

    public function test_customer_update_accepts_exact_current_path_and_keeps_file(): void
    {
        $customer = $this->makeCustomer($this->putFile('customers/mine.jpg'));

        $this->actingAs($this->admin)->postJson(
            route('admin.customers.update', $customer),
            $this->customerUpdatePayload($customer, ['profile_picture' => 'storage/customers/mine.jpg'])
        )->assertOk();

        $this->assertSame('storage/customers/mine.jpg', $customer->fresh()->profile_picture);
        Storage::disk('public')->assertExists('customers/mine.jpg');
    }

    // 4. Old owned file cleanup
    public function test_customer_update_replace_and_remove_delete_old_owned_file(): void
    {
        $customer = $this->makeCustomer($this->putFile('customers/old.jpg'));

        $this->actingAs($this->admin)->postJson(
            route('admin.customers.update', $customer),
            $this->customerUpdatePayload($customer, ['profile_picture' => UploadedFile::fake()->image('n.jpg', 300, 300)])
        )->assertOk();

        Storage::disk('public')->assertMissing('customers/old.jpg');
        $new = $customer->fresh()->profile_picture;
        Storage::disk('public')->assertExists(substr($new, strlen('storage/')));

        $this->actingAs($this->admin)->postJson(
            route('admin.customers.update', $customer),
            $this->customerUpdatePayload($customer, ['remove_pp' => 1])
        )->assertOk();

        $this->assertNull($customer->fresh()->profile_picture);
        Storage::disk('public')->assertMissing(substr($new, strlen('storage/')));
    }

    public function test_gallery_and_external_pictures_are_never_deleted(): void
    {
        Storage::disk('public')->put('gallery/shared.jpg', 'x');
        $customer = $this->makeCustomer('storage/gallery/shared.jpg');

        $this->actingAs($this->admin)->postJson(
            route('admin.customers.update', $customer),
            $this->customerUpdatePayload($customer, ['remove_pp' => 1])
        )->assertOk();

        Storage::disk('public')->assertExists('gallery/shared.jpg');
        $this->assertFalse(OwnedProfilePicture::isOwned('http://evil/x.png'));
        $this->assertFalse(OwnedProfilePicture::isOwned('storage/users/../../.env'));
        $this->assertFalse(OwnedProfilePicture::isOwned('storage/users/'));
        $this->assertTrue(OwnedProfilePicture::isOwned('storage/users/a.jpg'));
    }

    public function test_user_update_replace_and_remove_delete_old_owned_file(): void
    {
        $target = User::factory()->create(['email' => 'r9target@example.com', 'role_name' => 'viewer']);
        $target->assignRole('viewer');
        $target->forceFill(['profile_picture' => $this->putFile('users/old.jpg')])->save();

        $this->actingAs($this->admin)->post(route('users.update', $target->getKey()), array_merge(
            $this->userUpdatePayload($target),
            ['_method' => 'PATCH', 'profile_picture' => UploadedFile::fake()->image('a.jpg', 300, 300)]
        ), ['Accept' => 'application/json'])->assertOk();

        Storage::disk('public')->assertMissing('users/old.jpg');
        $new = $target->fresh()->profile_picture;
        Storage::disk('public')->assertExists(substr($new, strlen('storage/')));

        $this->actingAs($this->admin)->post(route('users.update', $target->getKey()), array_merge(
            $this->userUpdatePayload($target->fresh()),
            ['_method' => 'PATCH', 'remove_pp' => 1]
        ), ['Accept' => 'application/json'])->assertOk();

        $this->assertNull($target->fresh()->profile_picture);
        Storage::disk('public')->assertMissing(substr($new, strlen('storage/')));
    }

    public function test_profile_update_replace_deletes_old_owned_file(): void
    {
        $this->admin->forceFill(['profile_picture' => $this->putFile('users/mine.jpg')])->save();

        $this->actingAs($this->admin)->post(route('users.update_profile'), array_merge(
            $this->userUpdatePayload($this->admin),
            ['profile_picture' => UploadedFile::fake()->image('me.jpg', 256, 256)]
        ), ['Accept' => 'application/json'])->assertOk();

        Storage::disk('public')->assertMissing('users/mine.jpg');
        $this->assertNotSame('storage/users/mine.jpg', $this->admin->fresh()->profile_picture);
    }

    public function test_failed_user_store_leaves_no_orphan_file(): void
    {
        $this->mock(CreatesNewUsers::class, function ($mock) {
            $mock->shouldReceive('create')->andThrow(new \RuntimeException('create failed'));
        });

        $this->actingAs($this->admin)->post(route('users.store'), [
            'first_name' => 'Pic',
            'last_name' => 'User',
            'email' => 'orphan@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'gender' => 'male',
            'role_name' => 'viewer',
            'language' => 'en',
            'profile_picture' => UploadedFile::fake()->image('o.jpg', 300, 300),
        ], ['Accept' => 'application/json'])->assertOk()
            ->assertJsonPath('errors.0', __('alerts.errors.unknown'));

        $this->assertSame([], Storage::disk('public')->allFiles('users'));
    }

    // 6. Oversize message
    public function test_oversize_profile_picture_reports_max_size(): void
    {
        $rule = new AcceptableProfilePicture();
        $big = UploadedFile::fake()->image('big.jpg', 300, 300)->size(1500);

        $this->assertFalse($rule->passes('profile_picture', $big));
        $this->assertStringContainsString('1 MB', $rule->message());
        $this->assertStringNotContainsString('jpg, jpeg, png', $rule->message());

        $type = new AcceptableProfilePicture();
        $this->assertFalse($type->passes('profile_picture', UploadedFile::fake()->create('a.pdf', 10, 'application/pdf')));
        $this->assertStringContainsString('jpg, jpeg, png', $type->message());

        app()->setLocale('ar');
        $this->assertStringContainsString('1 MB', $rule->message());
    }
}

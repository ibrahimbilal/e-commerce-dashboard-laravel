<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Discount;
use App\Models\Gallery;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductLocale;
use App\Models\Review;
use App\Models\Subscriber;
use App\Models\Tag;
use App\Models\User;
use App\Support\DemoImageGenerator;
use App\Support\StoredMedia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    /** @var array<int, Attribute> */
    private array $colorAttributes = [];

    /** @var array<int, Attribute> */
    private array $sizeAttributes = [];

    /** @var array<int, ProductAttribute> */
    private array $variants = [];

    public function run(): void
    {
        $this->seedStaffUsers();
        $this->seedAttributes();
        $categories = $this->seedCategories();
        $tags = $this->seedTags();
        $products = $this->seedProducts($categories, $tags);
        $customers = $this->seedCustomers();
        $addresses = $this->seedAddresses($customers);
        $statuses = $this->seedOrderStatuses();
        $coupons = $this->seedCoupons();
        $this->seedDiscounts();
        $this->seedOrders($customers, $addresses, $statuses, $coupons, $products);
        $this->seedReviews($customers, $products);
        $this->seedInvoices();
        $this->seedGalleries();
        $this->seedSubscribers($customers);
        $this->reconcileDemoProductImages();
    }

    private function seedStaffUsers(): void
    {
        $manager = User::factory()->create([
            'email' => 'manager@example.com',
            'first_name' => 'Demo',
            'last_name' => 'Manager',
            'password' => Hash::make('password'),
        ]);
        $manager->markEmailAsVerified();
        $manager->assignRole('manager');

        $viewer = User::factory()->create([
            'email' => 'viewer@example.com',
            'first_name' => 'Demo',
            'last_name' => 'Viewer',
            'password' => Hash::make('password'),
        ]);
        $viewer->markEmailAsVerified();
        $viewer->assignRole('viewer');

        User::factory(8)->create()->each(function (User $user) {
            $user->markEmailAsVerified();
            $user->assignRole(fake()->randomElement(['manager', 'viewer']));
        });
    }

    private function seedAttributes(): void
    {
        foreach (['Red', 'Blue', 'Green', 'Black'] as $color) {
            $this->colorAttributes[] = Attribute::query()->create([
                'attribute_key' => 'Color',
                'attribute_value' => $color,
            ]);
        }

        foreach (['S', 'M', 'L', 'XL'] as $size) {
            $this->sizeAttributes[] = Attribute::query()->create([
                'attribute_key' => 'Size',
                'attribute_value' => $size,
            ]);
        }
    }

    /**
     * @return \Illuminate\Support\Collection<int, Category>
     */
    private function seedCategories()
    {
        $categories = Category::factory(28)->create();

        Category::factory(4)->create(['active' => false]);
        Category::factory(3)->create()->each(fn (Category $category) => $category->delete());

        return $categories;
    }

    /**
     * @return \Illuminate\Support\Collection<int, Tag>
     */
    private function seedTags()
    {
        $tags = collect();

        for ($i = 0; $i < 30; $i++) {
            $tags->push(Tag::query()->create([
                'title' => 'Tag '.($i + 1),
                'tag_slug' => 'tag-'.($i + 1),
                'deleted' => false,
                'parent_id' => null,
                'locale' => 'en',
            ]));
        }

        Tag::query()->latest('id')->limit(3)->get()->each->delete();

        return $tags;
    }

    /**
     * @param  \Illuminate\Support\Collection<int, Category>  $categories
     * @param  \Illuminate\Support\Collection<int, Tag>  $tags
     * @return \Illuminate\Support\Collection<int, Product>
     */
    private function seedProducts($categories, $tags)
    {
        $products = collect();

        for ($i = 0; $i < 35; $i++) {
            $product = Product::factory()->create([
                'status' => $i % 5 === 0 ? 'draft' : 'published',
                'featured' => $i % 7 === 0,
                'new' => $i % 4 === 0,
            ]);

            $productName = 'Demo Product '.($i + 1);

            ProductLocale::query()->create([
                'product_id' => $product->id,
                'locale' => 'en',
                'name' => $productName,
                'description' => 'Seeded demo product '.($i + 1),
                'product_slug' => 'demo-product-'.($i + 1),
            ]);

            $this->assignDemoProductImage($product, $productName);

            $product->categories()->attach($categories->random(rand(1, 2))->pluck('id'));
            $product->tags()->attach($tags->random(rand(1, 3))->pluck('id'));

            $color = fake()->randomElement($this->colorAttributes);
            $size = fake()->randomElement($this->sizeAttributes);

            $variant = ProductAttribute::query()->create([
                'product_id' => $product->id,
                'attribute_1_id' => $color->id,
                'attribute_2_id' => $size->id,
            ]);

            $this->variants[] = $variant;
            $products->push($product);
        }

        foreach (Product::factory(5)->published()->create() as $product) {
            ProductLocale::query()->create([
                'product_id' => $product->id,
                'locale' => 'en',
                'name' => 'Featured Product '.$product->id,
                'product_slug' => 'featured-'.$product->id,
            ]);
            $product->update(['featured' => true, 'sale_price' => (int) ($product->regular_price * 0.8)]);
            $this->assignDemoProductImage($product, 'Featured Product '.$product->id);
        }

        Product::query()->latest('id')->limit(4)->get()->each->delete();

        return $products;
    }

    /**
     * @return \Illuminate\Support\Collection<int, Customer>
     */
    private function seedCustomers()
    {
        $customers = Customer::factory(32)->create();
        Customer::factory(3)->create()->each->delete();

        return $customers;
    }

    /**
     * @param  \Illuminate\Support\Collection<int, Customer>  $customers
     * @return \Illuminate\Support\Collection<int, Address>
     */
    private function seedAddresses($customers)
    {
        $addresses = collect();

        foreach ($customers as $customer) {
            for ($i = 0; $i < rand(1, 2); $i++) {
                $addresses->push(Address::query()->create([
                    'customer_id' => $customer->id,
                    'address_title' => fake()->randomElement(['Home', 'Office', 'Billing']),
                    'mobile' => substr(fake()->e164PhoneNumber(), 0, 20),
                    'country' => fake()->country(),
                    'state' => fake()->state(),
                    'city' => fake()->city(),
                    'address_1' => fake()->streetAddress(),
                    'postcode' => (string) fake()->numberBetween(10000, 99999),
                ]));
            }
        }

        return $addresses;
    }

    /**
     * @return \Illuminate\Support\Collection<int, OrderStatus>
     */
    private function seedOrderStatuses()
    {
        $titles = ['Pending', 'Processing', 'Shipped', 'Completed', 'Cancelled'];

        return collect($titles)->map(fn (string $title) => OrderStatus::query()->create(['title' => $title]));
    }

    /**
     * @return \Illuminate\Support\Collection<int, Coupon>
     */
    private function seedCoupons()
    {
        $coupons = collect([
            Coupon::query()->create([
                'title' => 'Ten Percent Off',
                'code' => 'SAVE10',
                'discount' => 10,
                'type' => 'percent',
                'usage_limit' => 0,
                'usage_per_customer' => 0,
                'expired_at' => now()->addMonths(2),
                'active' => true,
            ]),
            Coupon::query()->create([
                'title' => 'Five Fixed Off',
                'code' => 'FIXED5',
                'discount' => 500,
                'type' => 'fixed',
                'usage_limit' => 0,
                'usage_per_customer' => 0,
                'expired_at' => now()->addMonth(),
                'active' => true,
            ]),
        ]);

        for ($i = 0; $i < 8; $i++) {
            $coupons->push(Coupon::query()->create([
                'title' => 'Coupon '.($i + 1),
                'code' => strtoupper(Str::random(6)),
                'discount' => fake()->randomElement([5, 10, 15, 500, 1000]),
                'type' => fake()->randomElement(['percent', 'fixed']),
                'usage_limit' => fake()->numberBetween(0, 50),
                'usage_per_customer' => fake()->numberBetween(0, 5),
                'expired_at' => fake()->boolean(70) ? now()->addDays(fake()->numberBetween(5, 90)) : now()->subDays(3),
                'active' => fake()->boolean(85),
            ]));
        }

        Coupon::query()->where('active', false)->orWhere('expired_at', '<', now())->limit(3)->get();
        Coupon::query()->latest('id')->limit(2)->get()->each->delete();

        return $coupons;
    }

    private function seedDiscounts(): void
    {
        for ($i = 0; $i < 12; $i++) {
            Discount::query()->create([
                'title' => 'Discount '.($i + 1),
                'discount' => fake()->numberBetween(5, 25),
                'type' => fake()->randomElement(['percent', 'fixed']),
                'start_date' => now()->subDays(10),
                'end_date' => fake()->boolean(75) ? now()->addDays(30) : now()->subDay(),
                'apply_to' => 'all',
                'active' => fake()->boolean(80),
            ]);
        }

        Discount::query()->latest('id')->limit(2)->get()->each->delete();
    }

    /**
     * @param  \Illuminate\Support\Collection<int, Customer>  $customers
     * @param  \Illuminate\Support\Collection<int, Address>  $addresses
     * @param  \Illuminate\Support\Collection<int, OrderStatus>  $statuses
     * @param  \Illuminate\Support\Collection<int, Coupon>  $coupons
     * @param  \Illuminate\Support\Collection<int, Product>  $products
     */
    private function seedOrders($customers, $addresses, $statuses, $coupons, $products): void
    {
        $adminId = User::query()->where('email', 'admin@example.com')->value('id') ?? 0;

        for ($i = 0; $i < 38; $i++) {
            $customer = $customers->random();
            $customerAddresses = $addresses->where('customer_id', $customer->id);
            $address = $customerAddresses->isNotEmpty() ? $customerAddresses->random() : $addresses->random();

            $variant = fake()->randomElement($this->variants);
            $product = $products->firstWhere('id', $variant->product_id) ?? Product::query()->find($variant->product_id);
            $unitPrice = $this->unitPriceForProduct($product);
            $quantity = fake()->numberBetween(1, 3);
            $lines = [[
                'product_attribute_id' => $variant->id,
                'quantity' => $quantity,
                'price' => $unitPrice,
            ]];

            $coupon = fake()->boolean(25) ? $coupons->where('active', true)->filter(fn (Coupon $c) => ! $c->expired_at || $c->expired_at->isFuture())->random() : null;
            $amount = $this->computeOrderAmount($lines, $coupon);

            $createdAt = $i < 5 ? now() : fake()->dateTimeBetween('-60 days', 'now');

            $order = Order::query()->create([
                'customer_id' => $customer->id,
                'address_id' => $address->id,
                'amount' => $amount,
                'order_status_id' => $statuses->random()->id,
                'coupon_id' => $coupon?->id,
                'updated_by' => $adminId,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            foreach ($lines as $line) {
                OrderItem::query()->create([
                    'order_id' => $order->id,
                    'product_attribute_id' => $line['product_attribute_id'],
                    'quantity' => $line['quantity'],
                    'price' => $line['price'],
                ]);
            }
        }

        Order::query()->latest('id')->limit(3)->get()->each->delete();
    }

    /**
     * @param  \Illuminate\Support\Collection<int, Customer>  $customers
     * @param  \Illuminate\Support\Collection<int, Product>  $products
     */
    private function seedReviews($customers, $products): void
    {
        for ($i = 0; $i < 25; $i++) {
            Review::query()->create([
                'customer_id' => $customers->random()->id,
                'product_id' => $products->random()->id,
                'comment' => fake()->sentence(),
                'rate' => fake()->numberBetween(1, 5),
            ]);
        }

        Review::query()->latest('id')->limit(3)->get()->each->delete();
    }

    private function seedInvoices(): void
    {
        $invoiceNo = 1000;

        Order::query()->latest('id')->limit(20)->get()->each(function (Order $order) use (&$invoiceNo) {
            Invoice::query()->create([
                'invoice_no' => $invoiceNo++,
                'order_id' => $order->id,
            ]);
        });

        Invoice::query()->latest('id')->limit(2)->get()->each->delete();
    }

    private function assignDemoProductImage(Product $product, string $label): void
    {
        $path = DemoImageGenerator::writeProductImage($product->id, $label, $product->id);

        if ($path) {
            $product->forceFill(['product_img' => StoredMedia::normalizeStoredPath($path)])->save();
        }
    }

    private function reconcileDemoProductImages(): void
    {
        Product::query()->each(function (Product $product) {
            $relative = 'demo/products/product-'.$product->id.'.png';

            if (! Storage::disk('public')->exists($relative)) {
                DemoImageGenerator::writeProductImage(
                    $product->id,
                    'Demo Product '.$product->id,
                    $product->id
                );
            }

            if (Storage::disk('public')->exists($relative)) {
                $product->forceFill([
                    'product_img' => StoredMedia::databasePath($relative),
                ])->save();
            }
        });
    }

    /**
     * @param  \Illuminate\Support\Collection<int, Customer>  $customers
     */
    private function seedSubscribers($customers): void
    {
        if (Subscriber::query()->count() > 0) {
            return;
        }

        foreach ($customers->take(15) as $customer) {
            Subscriber::query()->create([
                'email' => $customer->email,
                'customer_id' => $customer->id,
                'is_subscriber' => true,
                'token' => Str::random(16),
            ]);
        }

        for ($i = 0; $i < 10; $i++) {
            Subscriber::query()->create([
                'email' => 'subscriber'.($i + 1).'@demo.example.com',
                'customer_id' => null,
                'is_subscriber' => fake()->boolean(85),
                'token' => Str::random(16),
            ]);
        }
    }

    private function seedGalleries(): void
    {
        if (Gallery::query()->count() > 0) {
            return;
        }

        $userId = User::query()->where('email', 'admin@example.com')->value('id')
            ?? User::query()->value('id');

        if (! $userId) {
            return;
        }

        for ($i = 1; $i <= 20; $i++) {
            Gallery::query()->create([
                'url' => 'demo/gallery-'.$i.'.jpg',
                'metas' => ['alt' => 'Demo gallery '.$i],
                'sizes_url' => null,
                'user_id' => $userId,
            ]);
        }
    }

    private function unitPriceForProduct(?Product $product): int
    {
        if (! $product) {
            return 0;
        }

        return max(0, (int) ($product->sale_price ?? $product->regular_price ?? 0));
    }

    /**
     * @param  array<int, array{product_attribute_id: int, quantity: int, price: int}>  $lines
     */
    private function computeOrderAmount(array $lines, ?Coupon $coupon): int
    {
        $subtotal = array_sum(array_map(fn (array $line) => $line['quantity'] * $line['price'], $lines));

        if (! $coupon) {
            return max(0, $subtotal);
        }

        $deduction = 0;
        $type = strtolower((string) ($coupon->type ?? 'percent'));

        if ($type === 'fixed') {
            $deduction = (int) round((float) $coupon->discount);
        } else {
            $deduction = (int) round($subtotal * ((float) $coupon->discount / 100));
        }

        return max(0, $subtotal - $deduction);
    }
}

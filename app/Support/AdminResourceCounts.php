<?php

namespace App\Support;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Discount;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\Review;
use App\Models\Subscriber;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Str;

class AdminResourceCounts
{
    /**
     * @return array<string, int>
     */
    public static function products(): array
    {
        return [
            'all' => Product::query()->count(),
            'published' => Product::query()->where('status', 'published')->count(),
            'draft' => Product::query()->where('status', 'draft')->count(),
            'trashed' => Product::query()->onlyTrashed()->count(),
            'featured' => Product::query()->where('featured', true)->count(),
            'new' => Product::query()->where('new', true)->count(),
            'sale' => Product::query()
                ->whereNotNull('sale_price')
                ->whereColumn('sale_price', '<', 'regular_price')
                ->count(),
        ];
    }

    /**
     * @return array<string, int>
     */
    public static function categories(): array
    {
        return [
            'all' => Category::query()->count(),
            'active' => Category::query()->where('active', true)->count(),
            'inactive' => Category::query()->where('active', false)->count(),
            'trashed' => Category::query()->onlyTrashed()->count(),
        ];
    }

    /**
     * @return array<string, int>
     */
    public static function coupons(): array
    {
        return [
            'all' => Coupon::query()->count(),
            'active' => CouponQuery::activeWithinDates()->count(),
            'inactive' => CouponQuery::inactiveNotExpired()->count(),
            'expired' => CouponQuery::expiredByDate()->count(),
            'trashed' => Coupon::query()->onlyTrashed()->count(),
        ];
    }

    /**
     * @return array<string, int>
     */
    public static function discounts(): array
    {
        return [
            'all' => Discount::query()->count(),
            'active' => DiscountQuery::activeWithinDates()->count(),
            'inactive' => DiscountQuery::inactiveNotExpired()->count(),
            'expired' => DiscountQuery::expiredByDate()->count(),
            'trashed' => Discount::query()->onlyTrashed()->count(),
        ];
    }

    /**
     * @return array<string, int>
     */
    public static function tags(): array
    {
        return [
            'all' => Tag::query()->count(),
            'trashed' => Tag::query()->onlyTrashed()->count(),
        ];
    }

    /**
     * @return array<string, int>
     */
    public static function customers(): array
    {
        return [
            'all' => Customer::query()->count(),
            'trashed' => Customer::query()->onlyTrashed()->count(),
        ];
    }

    /**
     * @return array<string, int>
     */
    public static function reviews(): array
    {
        $counts = [
            'all' => Review::query()->count(),
            'trashed' => Review::query()->onlyTrashed()->count(),
        ];

        for ($star = 1; $star <= 5; $star++) {
            $counts['star_'.$star] = Review::query()->where('rate', $star)->count();
        }

        return $counts;
    }

    /**
     * @return array<string, int>
     */
    public static function orders(): array
    {
        $counts = [
            'all' => Order::query()->count(),
            'trashed' => Order::query()->onlyTrashed()->count(),
        ];

        foreach (OrderStatus::query()->orderBy('title')->get() as $status) {
            $counts[Str::slug($status->title)] = Order::query()
                ->where('order_status_id', $status->id)
                ->count();
        }

        return $counts;
    }

    /**
     * @return array<string, int>
     */
    public static function invoices(): array
    {
        return [
            'all' => Invoice::query()->count(),
            'trashed' => Invoice::query()->onlyTrashed()->count(),
        ];
    }

    /**
     * @return array<string, int>
     */
    public static function orderStatuses(): array
    {
        return [
            'all' => OrderStatus::query()->count(),
            'trashed' => OrderStatus::query()->onlyTrashed()->count(),
        ];
    }

    /**
     * @return array<string, int>
     */
    public static function attributes(): array
    {
        return [
            'all' => Attribute::query()->count(),
        ];
    }

    /**
     * @return array<string, int>
     */
    public static function marketing(): array
    {
        return [
            'all' => Subscriber::query()->count(),
            'subscribers' => Subscriber::query()->where('is_subscriber', true)->count(),
            'not_subscribers' => Subscriber::query()->where('is_subscriber', false)->count(),
        ];
    }

    /**
     * Users list has no $counts tabs yet; provide stable keys for AJAX row actions.
     *
     * @return array<string, int>
     */
    public static function users(): array
    {
        return [
            'all' => User::query()->count(),
            'active' => User::query()->where('status', 'active')->count(),
            'inactive' => User::query()->where('status', 'inactive')->count(),
            'trashed' => User::query()->onlyTrashed()->count(),
        ];
    }

    /**
     * @return array<string, list<string>>
     */
    public static function toggleFieldWhitelist(): array
    {
        return [
            'products' => ['new', 'featured'],
            'categories' => ['active'],
            'coupons' => ['active'],
            'discounts' => ['active'],
            'marketing.subscribers' => ['is_subscriber'],
        ];
    }
}

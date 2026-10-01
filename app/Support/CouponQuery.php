<?php

namespace App\Support;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Builder;

class CouponQuery
{
    public static function activeWithinDates(): Builder
    {
        return Coupon::query()
            ->where('active', true)
            ->where(function (Builder $query) {
                $query->whereNull('expired_at')
                    ->orWhere('expired_at', '>=', now());
            });
    }

    public static function expiredByDate(): Builder
    {
        return Coupon::query()
            ->whereNotNull('expired_at')
            ->where('expired_at', '<', now());
    }

    public static function isUsableForNewSelection(Coupon $coupon): bool
    {
        if (! $coupon->active) {
            return false;
        }

        if ($coupon->expired_at && $coupon->expired_at->isPast()) {
            return false;
        }

        if ($coupon->usage_limit > 0 && $coupon->orders()->count() >= $coupon->usage_limit) {
            return false;
        }

        return true;
    }
}

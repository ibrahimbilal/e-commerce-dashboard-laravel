<?php

namespace App\Support;

use App\Models\Discount;
use Illuminate\Database\Eloquent\Builder;

class DiscountQuery
{
    public static function activeWithinDates(): Builder
    {
        return Discount::query()
            ->where('active', true)
            ->where(function (Builder $query) {
                $query->whereNull('start_date')->orWhere('start_date', '<=', now());
            })
            ->where(function (Builder $query) {
                $query->whereNull('end_date')->orWhere('end_date', '>=', now());
            });
    }

    public static function expiredByDate(): Builder
    {
        return Discount::query()
            ->whereNotNull('end_date')
            ->where('end_date', '<', now());
    }

    public static function inactiveNotExpired(): Builder
    {
        return Discount::query()
            ->where('active', false)
            ->where(function (Builder $query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            });
    }
}

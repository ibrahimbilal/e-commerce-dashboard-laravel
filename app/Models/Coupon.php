<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'code',
        'discount',
        'type',
        'usage_limit',
        'usage_per_customer',
        'expired_at',
        'active',
    ];

    protected $casts = [
        'discount' => 'float',
        'expired_at' => 'datetime',
        'active' => 'boolean',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function customers(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class, 'customer_coupons_usage')
            ->withPivot('times_used');
    }
}

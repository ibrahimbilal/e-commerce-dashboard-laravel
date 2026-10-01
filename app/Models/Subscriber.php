<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscriber extends Model
{
    protected $table = 'subscribers_list';

    protected $fillable = [
        'email',
        'customer_id',
        'token',
        'is_subscriber',
    ];

    protected $casts = [
        'is_subscriber' => 'boolean',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}

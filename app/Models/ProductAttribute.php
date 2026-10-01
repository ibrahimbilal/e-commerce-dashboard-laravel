<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductAttribute extends Model
{
    protected $table = 'products_attributes';

    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'attribute_1_id',
        'attribute_2_id',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function attributeOne(): BelongsTo
    {
        return $this->belongsTo(Attribute::class, 'attribute_1_id');
    }

    public function attributeTwo(): BelongsTo
    {
        return $this->belongsTo(Attribute::class, 'attribute_2_id');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'product_attribute_id');
    }
}

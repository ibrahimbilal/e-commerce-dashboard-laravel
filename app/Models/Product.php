<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'sku',
        'product_img',
        'regular_price',
        'sale_price',
        'schedule_sale',
        'quantity',
        'status',
        'new',
        'featured',
    ];

    protected $casts = [
        'new' => 'boolean',
        'featured' => 'boolean',
    ];

    public function locales(): HasMany
    {
        return $this->hasMany(ProductLocale::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'products_cats', 'product_id', 'cat_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'products_tags');
    }

    public function productAttributes(): HasMany
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}

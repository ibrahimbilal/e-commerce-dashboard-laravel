<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductLocale extends Model
{
    public $timestamps = false;

    public $incrementing = false;

    protected $primaryKey = null;

    protected $fillable = [
        'product_id',
        'locale',
        'name',
        'description',
        'product_slug',
        'meta_title',
        'meta_keywords',
        'meta_description',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}

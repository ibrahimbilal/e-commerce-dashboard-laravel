<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attribute extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'attribute_key',
        'attribute_value',
    ];

    public function productAttributesAsFirst(): HasMany
    {
        return $this->hasMany(ProductAttribute::class, 'attribute_1_id');
    }

    public function productAttributesAsSecond(): HasMany
    {
        return $this->hasMany(ProductAttribute::class, 'attribute_2_id');
    }
}

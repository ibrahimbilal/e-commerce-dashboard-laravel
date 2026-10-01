<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'tag_slug',
        'deleted',
        'parent_id',
        'locale',
        'meta_title',
        'meta_keywords',
        'meta_description',
    ];

    protected $casts = [
        'deleted' => 'boolean',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Tag::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Tag::class, 'parent_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'products_tags');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'img_url',
        'img_meta',
        'img_sizes_url',
        'deleted',
    ];

    protected $casts = [
        'deleted' => 'boolean',
    ];
}

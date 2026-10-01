<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'discount',
        'type',
        'start_date',
        'end_date',
        'apply_to',
        'active',
    ];

    protected $casts = [
        'discount' => 'float',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'active' => 'boolean',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    public $incrementing = false;

    protected $keyType = 'int';

    protected $fillable = [
        'id',
        'code',
        'symbol',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lang extends Model
{
    protected $table = 'langs';

    public $incrementing = false;

    protected $keyType = 'int';

    protected $fillable = [
        'id',
        'code',
        'name',
        'direction',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];
}

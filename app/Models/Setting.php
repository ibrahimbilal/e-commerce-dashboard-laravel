<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

	/**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
	protected $fillable = [
		'setting_key',
		'setting_value'
	];

	/**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

	protected $casts = [
        'reviews' => 'boolean',
        'guest_reviews' => 'boolean',
        'guest_checkout' => 'boolean',
        'wishlist' => 'boolean',
        'compare' => 'boolean',
        'out_of_stock_products' => 'boolean',
        'social_share' => 'boolean',
        'recently_viewed' => 'boolean',
        'recommend' => 'boolean',

		'share_on' => 'array'
    ];
}

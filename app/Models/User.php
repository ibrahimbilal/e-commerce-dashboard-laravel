<?php

namespace App\Models;

use App\Models\Role;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
		'last_name',
		'email',
		'password',
		'mobile',
		'birth_date',
		'gender',
		'role_id',
		'status',
		'language',
		'profile_picture',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
		'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

	// Relationship with Role Table
	public function roles() {
		return $this->belongsTo(Role::class, 'role_id', 'id');
	}

	/**
     * Interact with the user's status.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => str_replace('_', ' ', $value)
        );
    }

	/**
     * Interact with the user's birth date.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function birth_date(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? date("Y,m,d", strtotime($this->birth_date)) : ''
        );
    }
}

<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable, SoftDeletes, TwoFactorAuthenticatable;

    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'mobile',
        'profile_picture',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Blade compatibility for legacy roleRelation->title (Spatie roles).
     */
    public function getRoleRelationAttribute(): ?object
    {
        $role = $this->relationLoaded('roles')
            ? $this->roles->first()
            : $this->roles()->first();

        if (! $role) {
            return null;
        }

        return (object) [
            'id' => $role->id,
            'title' => $role->name,
        ];
    }
}

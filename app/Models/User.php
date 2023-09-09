<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'tenant_id',
        'email_verified_at',
        'password',
        'cellphone',
        'token',
        'token_expires_in'
    ];

    public function stores()
    {
        return $this->hasMany(UserStore::class);
    }

    public function subscription()
    {
        return $this->hasOne(UserSubscription::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

}

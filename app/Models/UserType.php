<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserType extends Authenticatable implements JWTSubject
{
    use HasFactory;

    public $timestamps = false;


    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    public function order()
    {
        return $this->hasOne('App\Models\Order');
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

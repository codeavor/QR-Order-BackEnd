<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    use HasFactory;

    public $timestamps = false;


    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    public function umbrella()
    {
        return $this->belongsTo('App\Models\UserType');
    }

}

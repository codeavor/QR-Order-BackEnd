<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Umbrella extends Model
{
    // Timestamps
    public $timestamps = false;

    // Field that has to be filled
    protected $fillable = ['id'];

    // One to Many relation, one order has one umbrella, one umbrella has many orders
    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}

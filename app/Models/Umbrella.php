<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Umbrella extends Model
{
    use HasFactory;

    // Timestamps
    public $timestamps = false;

    // Field that has to be filled
    protected $fillable = ['id'];

    // One to Many relation, one order has one umbrella, one umbrella has many orders
    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }
}

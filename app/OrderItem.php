<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    // Timestamps
    public $timestamps = false;

    // Field that has to be filled
    protected $fillable = ['quantity'];

    // Many to Many relation, one order item has many extras, one extra has many order items
    public function extras()
    {
        return $this->belongsToMany('App\Extra', 'order_item_extras');
    }
}

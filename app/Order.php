<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Timestamps
    public $timestamps = true;

    // Field that has to be filled
    protected $fillable = ['order_complete'];

    // One to Many relation, one order has one umbrella, one umbrella has many orders
    public function umbrella()
    {
        return $this->belongsTo('App\Umbrella');
    }

    // Many to Many relation, one item has many orders, one order has many items
    public function items()
    {
        return $this->belongsToMany('App\Item', 'order_items')->withPivot('quantity');
    }
}

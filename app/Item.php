<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    // Timestamps
    public $timestamps = false;

    // Field that has to be filled
    protected $fillable = ['name', 'price'];

    // One to Many relation, one item has one category, one category has many items
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    // Many to Many relation, one item has many orders, one order has many items
    public function orders()
    {
        return $this->belongsToMany('App\Order', 'order_items')->withPivot('quantity');
    }

    // Many to Many relation, one item has many extras, one extra has many items
    public function extras()
    {
        return $this->belongsToMany('App\Extra', 'item_extras');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{
    // Timestamps
    public $timestamps = false;

    // Field that has to be filled
    protected $fillable = ['name', 'price'];
    
    // Many to Many relation, one order item has many extras, one extra has many order items
    public function order_items()
    {
        return $this->belongsToMany('App\Models\OrderItem', 'order_item_extras');
    }

    // Many to Many relation, one item has many extras, one extra has many items
    public function items()
    {
        return $this->belongsToMany('App\Models\Item', 'item_extras');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    // Timestamps
    public $timestamps = true;

    // Field that has to be filled
    protected $fillable = ['order_complete', 'umbrella_id'];

    // One to Many relation, one order has one user, one user has many orders
    public function userType()
    {
        return $this->belongsTo('App\Models\UserType');
    }

    // Many to Many relation, one item has many orders, one order has many items
    public function items()
    {
        return $this->belongsToMany('App\Models\Item', 'order_items')->withPivot('quantity');
    }
}

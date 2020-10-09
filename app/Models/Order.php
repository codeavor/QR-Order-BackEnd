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
    protected $fillable = ['order_complete','remember_token'];

     /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['remember_token'];

    // One to Many relation, one order has one umbrella, one umbrella has many orders
    public function umbrella()
    {
        return $this->belongsTo('App\Models\Umbrella');
    }

    // Many to Many relation, one item has many orders, one order has many items
    public function items()
    {
        return $this->belongsToMany('App\Models\Item', 'order_items')->withPivot('quantity');
    }
}

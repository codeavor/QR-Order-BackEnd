<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    // Timestamps
    public $timestamps = false;

    // Field that has to be filled
    protected $fillable = ['quantity'];

    // Many to Many relation, one order item has many extras, one extra has many order items
    public function extras()
    {
        return $this->belongsToMany('App\Models\Extra', 'order_item_extras');
    }
}

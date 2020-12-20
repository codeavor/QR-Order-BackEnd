<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    // Timestamps
    public $timestamps = false;

    // Field that has to be filled
    protected $fillable = ['name', 'price','description'];

    // One to Many relation, one item has one category, one category has many items
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    // Many to Many relation, one item has many orders, one order has many items
    public function orders()
    {
        return $this->belongsToMany('App\Models\Order', 'order_items')->withPivot('order_id', 'item_id', 'quantity', 'notes');
    }

    // Many to Many relation, one item has many orders, one order has many items
    public function extra_categories()
    {
        return $this->belongsToMany('App\Models\ExtraCategory', 'item_extra_categories');
    }
}

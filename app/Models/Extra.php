<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Extra extends Model
{
    use HasFactory;

    // Timestamps
    public $timestamps = false;

    // Field that has to be filled
    protected $fillable = ['name', 'price'];
    
    // Many to Many relation, one order item has many extras, one extra has many order items
    public function orderItems()
    {
        return $this->belongsToMany('App\Models\OrderItem', 'order_item_extras');
    }

    // Many to Many relation, one extra has many categories, one category has many extras
    public function extra_categories()
    {
        return $this->belongsToMany('App\Models\ExtraCategory', 'extra_category_extras');
    }
}

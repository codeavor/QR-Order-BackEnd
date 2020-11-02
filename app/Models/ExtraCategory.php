<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtraCategory extends Model
{
    use HasFactory;

    // Timestamps
    public $timestamps = false;

    // Field that has to be filled
    protected $fillable = ['name', 'type'];

    // Many to Many relation, one extra has many categories, one category has many extras
    public function extras()
    {
        return $this->belongsToMany('App\Models\Extra', 'extra_category_extras');
    }

    // Many to Many relation, one item has many orders, one order has many items
    public function items()
    {
        return $this->belongsToMany('App\Models\Item', 'item_extra_categories');
    }
}

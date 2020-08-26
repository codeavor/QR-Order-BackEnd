<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Timestamps
    public $timestamps = false;

    // Field that has to be filled
    protected $fillable = ['name', 'description'];

    // One to Many relation, one item has one category, one category has many items
    public function items()
    {
        return $this->hasMany('App\Item');
    }
}

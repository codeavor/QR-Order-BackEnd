<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    // Timestamps
    public $timestamps = false;

    // Field that has to be filled
    protected $fillable = ['name', 'description'];

    // One to Many relation, one item has one category, one category has many items
    public function items()
    {
        return $this->hasMany('App\Models\Item');
    }
}

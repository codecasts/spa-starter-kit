<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

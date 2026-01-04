<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
    ];

    // Relationships
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

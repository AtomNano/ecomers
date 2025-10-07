<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'price_per_piece',
        'price_per_four',
        'price_per_dozen',
        'stock',
        'is_featured',
        'sales_count',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
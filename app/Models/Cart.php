<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Accessors
    public function getUnitPriceAttribute()
    {
        $product = $this->product;
        
        if ($this->price_type === 'bulk_4') {
            return $product->price_bulk_4 ?? $product->price_unit;
        } elseif ($this->price_type === 'dozen') {
            return $product->price_dozen ?? $product->price_unit;
        }
        
        return $product->price_unit;
    }

    public function getSubtotalAttribute()
    {
        return $this->quantity * $this->getUnitPriceAttribute();
    }
}

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

    public function tierPrices()
    {
        return $this->hasMany(ProductTierPrice::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Get the appropriate price for a given quantity and customer group
     */
    public function getPriceForQuantity($quantity, $customerGroupId = null)
    {
        $tierPrice = ProductTierPrice::getPriceForQuantity($this->id, $quantity, $customerGroupId);
        
        if ($tierPrice) {
            return $tierPrice->price;
        }

        // Fallback to default pricing
        if ($quantity >= 12 && $this->price_per_dozen) {
            return $this->price_per_dozen;
        } elseif ($quantity >= 4 && $this->price_per_four) {
            return $this->price_per_four;
        }

        return $this->price_per_piece;
    }

    /**
     * Get all tier prices for this product
     */
    public function getTierPrices($customerGroupId = null)
    {
        $query = $this->tierPrices()->where('is_active', true);
        
        if ($customerGroupId) {
            $query->where(function($q) use ($customerGroupId) {
                $q->where('customer_group_id', $customerGroupId)
                  ->orWhereNull('customer_group_id');
            });
        } else {
            $query->whereNull('customer_group_id');
        }

        return $query->orderBy('min_quantity')->get();
    }
}
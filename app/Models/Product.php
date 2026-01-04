<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\PricingHelper;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'category_id',
        'image',
        'price_unit',
        'price_bulk_4',
        'price_dozen',
        'stock',
        'unit',
        'box_item_count',
        'is_featured',
        'min_stock',
    ];

    protected $casts = [
        'price_unit' => 'decimal:2',
        'price_bulk_4' => 'decimal:2',
        'price_dozen' => 'decimal:2',
        'is_featured' => 'boolean',
    ];

    /**
     * ✅ REFACTORED: Delegate pricing to PricingHelper (Single Source of Truth)
     * Menghilangkan duplikasi logic di Model
     */
    public function calculateEffectivePrice($quantity)
    {
        $pricingData = PricingHelper::calculateItemPrice($this, $quantity);
        return $pricingData['effective_price'];
    }

    /**
     * Get price by tier type
     */
    public function getPrice($type = 'unit')
    {
        return match($type) {
            'bulk_4' => (float) $this->price_bulk_4 ?? (float) $this->price_unit,
            'dozen' => (float) $this->price_dozen ?? (float) $this->price_unit,
            default => (float) $this->price_unit
        };
    }

    /**
     * Determine price tier berdasarkan quantity (via PricingHelper)
     */
    public function determineTier($quantity)
    {
        $pricingData = PricingHelper::calculateItemPrice($this, $quantity);
        return $pricingData['price_type'];
    }

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function priceTiers()
    {
        return $this->hasMany(PriceTier::class);
    }
    /**
     * Get discount amount between unit and bulk_4 price
     */
    public function getDiscount()
    {
        $unitPrice = (float) $this->price_unit;
        $bulkPrice = (float) ($this->price_bulk_4 ?? $this->price_unit);
        return max(0, $unitPrice - $bulkPrice);
    }

    /**
     * Get discount percentage
     */
    public function getDiscountPercent()
    {
        $unitPrice = (float) $this->price_unit;
        if ($unitPrice == 0) return 0;
        return round(($this->getDiscount() / $unitPrice) * 100);
    }
}

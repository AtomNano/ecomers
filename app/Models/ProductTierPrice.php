<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTierPrice extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'product_id',
        'customer_group_id',
        'min_quantity',
        'price',
        'tier_name',
        'is_active'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function customerGroup()
    {
        return $this->belongsTo(CustomerGroup::class);
    }

    /**
     * Get the appropriate price for a product based on quantity and customer group
     */
    public static function getPriceForQuantity($productId, $quantity, $customerGroupId = null)
    {
        $query = self::where('product_id', $productId)
            ->where('min_quantity', '<=', $quantity)
            ->where('is_active', true)
            ->orderBy('min_quantity', 'desc');

        if ($customerGroupId) {
            $query->where(function($q) use ($customerGroupId) {
                $q->where('customer_group_id', $customerGroupId)
                  ->orWhereNull('customer_group_id');
            });
        } else {
            $query->whereNull('customer_group_id');
        }

        return $query->first();
    }
}

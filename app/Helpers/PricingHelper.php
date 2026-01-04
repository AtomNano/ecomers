<?php

namespace App\Helpers;

use App\Models\Product;

/**
 * PRICING ENGINE - Smart Tiered Pricing Calculator
 * 
 * Konsep: Sistem otomatis menentukan harga termurah berdasarkan quantity
 * Tidak perlu menu terpisah "Beli Ecer" vs "Beli Dus", user hanya input qty
 * Sistem akan otomatis hitung tier mana yang paling murah
 */
class PricingHelper
{
    /**
     * Calculate effective unit price berdasarkan quantity
     * 
     * Rule A (Box Tier - Termurah):
     *   Jika qty >= box_item_count (misal 12), gunakan effective price
     *   Contoh: Price Dozen 120.000 ÷ 12 = 10.000/pcs
     * 
     * Rule B (Wholesale Tier):
     *   Jika qty >= 4, gunakan price_bulk_4
     *   Contoh: Price Bulk 12.000/pcs
     * 
     * Rule C (Unit Tier - Termahal):
     *   Otherwise, gunakan price_unit
     *   Contoh: Price Unit 15.000/pcs
     * 
     * ⚠️ CRITICAL ROUNDING LOGIC (FATAL ERROR #3):
     *    round(..., 0) membulatkan ke angka terdekat
     *    
     *    CONTOH PROBLEM:
     *    - Price Dozen: Rp 49.900 (isi 3 pcs)
     *    - 49.900 ÷ 3 = 16.633,33
     *    - round(16.633.33, 0) = 16.633
     *    - Total bayar: 16.633 × 3 = 49.899
     *    - HILANG Rp 1 rupiah!
     *    
     *    RISK ASSESSMENT:
     *    - Untuk MVP: ACCEPTABLE (selisih receh, masuk kategori rounding error)
     *    - Untuk Production: Pastikan price_dozen SELALU habis dibagi box_item_count
     *    - Contoh aman: Price 120.000 ÷ 12 pcs = 10.000 (exact)
     *    
     *    SOLUSI JANGKA PANJANG:
     *    1. Saat input produk, VALIDASI: price_dozen % box_item_count === 0
     *    2. Atau terima selisih receh sebagai "rounding tolerance" maksimal Rp 10/pcs
     *    3. Atau gunakan DECIMAL(15,4) untuk presisi lebih tinggi (tidak praktis)
     * 
     * @param Product $product
     * @param int $quantity Jumlah pcs yang mau dibeli
     * @return array [
     *     'effective_price' => (float) harga satuan yg berlaku,
     *     'price_type' => 'unit'|'bulk_4'|'dozen',
     *     'total_price' => (float) harga total (effective_price * quantity),
     *     'box_count' => (int) jumlah box jika tipe dozen,
     * ]
     */
    public static function calculateItemPrice(Product $product, int $quantity): array
    {
        // Safety check
        if ($quantity <= 0) {
            throw new \InvalidArgumentException('Quantity harus lebih dari 0');
        }

        $boxCount = (int) ($product->box_item_count ?? 12);
        $priceType = 'unit'; // Default
        $effectivePrice = (float) $product->price_unit;

        // Rule A: Box Tier (Termurah)
        if ($quantity >= $boxCount && $product->price_dozen) {
            // Hitung effective price dari box price
            $effectivePrice = round((float) $product->price_dozen / $boxCount, 0);
            $priceType = 'dozen';
        }
        // Rule B: Wholesale Tier
        elseif ($quantity >= 4 && $product->price_bulk_4) {
            $effectivePrice = (float) $product->price_bulk_4;
            $priceType = 'bulk_4';
        }
        // Rule C: Unit Tier (Default)
        else {
            $effectivePrice = (float) $product->price_unit;
            $priceType = 'unit';
        }

        // Calculate total price
        $totalPrice = $effectivePrice * $quantity;

        return [
            'effective_price' => $effectivePrice,
            'price_type' => $priceType,
            'total_price' => round($totalPrice, 0), // Round ke rupiah bulat
            'box_count' => $priceType === 'dozen' ? ceil($quantity / $boxCount) : 0,
            'description' => self::getPriceDescription($product, $quantity, $priceType)
        ];
    }

    /**
     * Generate user-friendly price description
     * Untuk ditampilkan di invoice atau receipt
     */
    public static function getPriceDescription(Product $product, int $quantity, string $priceType): string
    {
        $boxCount = (int) ($product->box_item_count ?? 12);
        
        return match($priceType) {
            'dozen' => sprintf(
                'Harga Dus (%d %s/dus × %d = %d pcs)',
                $boxCount,
                $product->unit,
                ceil($quantity / $boxCount),
                $quantity
            ),
            'bulk_4' => sprintf('Harga Grosir (min. 4 %s)', $product->unit),
            'unit' => sprintf('Harga Satuan (1-%d %s)', $boxCount - 1, $product->unit),
            default => 'Harga Satuan'
        };
    }

    /**
     * Get breakdown of all available prices untuk display di UI
     * Gunakan ini untuk show customer "jika beli 12, harga jadi berapa"
     */
    public static function getPriceBreakdown(Product $product): array
    {
        $boxCount = (int) ($product->box_item_count ?? 12);
        
        return [
            'unit' => [
                'price' => (float) $product->price_unit,
                'min_qty' => 1,
                'label' => sprintf('%s (1-%d %s)', $product->unit, $boxCount - 1, $product->unit),
            ],
            'bulk_4' => [
                'price' => (float) $product->price_bulk_4 ?? (float) $product->price_unit,
                'min_qty' => 4,
                'label' => sprintf('Grosir (4-%d %s)', $boxCount - 1, $product->unit),
                'available' => (bool) $product->price_bulk_4
            ],
            'dozen' => [
                'price' => (float) $product->price_dozen ?? (float) $product->price_unit,
                'effective_unit_price' => $product->price_dozen ? round((float) $product->price_dozen / $boxCount, 0) : 0,
                'min_qty' => $boxCount,
                'box_item_count' => $boxCount,
                'label' => sprintf('Per Dus (%d %s)', $boxCount, $product->unit),
                'available' => (bool) $product->price_dozen
            ]
        ];
    }
}

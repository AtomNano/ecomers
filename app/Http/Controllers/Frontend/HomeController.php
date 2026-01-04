<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured products
        $featuredProducts = Product::with('category')
            ->where('is_featured', true)
            ->where('stock', '>', 0)
            ->limit(8)
            ->get();

        // Get best selling products
        $bestSellers = Product::with('category')
            ->where('stock', '>', 0)
            ->orderBy('sales_count', 'desc')
            ->limit(8)
            ->get();

        // Get categories with product count
        $categories = Category::withCount('products')
            ->whereHas('products')
            ->limit(6)
            ->get();

        return view('frontend.home', compact('featuredProducts', 'bestSellers', 'categories'));
    }
}

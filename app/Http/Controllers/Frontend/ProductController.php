<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->where('stock', '>', 0);

        // Search
        if ($request->filled('q')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->q . '%')
                  ->orWhere('description', 'like', '%' . $request->q . '%');
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Price filter
        if ($request->filled('price')) {
            $priceRange = $request->price;
            if ($priceRange === '0-10000') {
                $query->where('price_per_piece', '<=', 10000);
            } elseif ($priceRange === '10000-50000') {
                $query->whereBetween('price_per_piece', [10000, 50000]);
            } elseif ($priceRange === '50000-100000') {
                $query->whereBetween('price_per_piece', [50000, 100000]);
            } elseif ($priceRange === '100000+') {
                $query->where('price_per_piece', '>=', 100000);
            }
        }

        // In stock filter
        if ($request->filled('in_stock')) {
            $query->where('stock', '>', 0);
        }

        // Sort
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'bestseller':
                $query->orderBy('sales_count', 'desc');
                break;
            case 'price_low':
                $query->orderBy('price_per_piece', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price_per_piece', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12);
        $categories = Category::withCount('products')->whereHas('products')->get();

        return view('frontend.products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $product->load('category', 'tierPrices');
        
        // Get related products
        $relatedProducts = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('stock', '>', 0)
            ->limit(4)
            ->get();

        return view('frontend.products.show', compact('product', 'relatedProducts'));
    }

    public function search(Request $request)
    {
        return $this->index($request);
    }
}
<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Public Products Index - Accessible without login
     */
    public function publicIndex()
    {
        $categories = Category::all();
        $query = Product::with('category');
        
        if (request('category')) {
            $query->where('category_id', request('category'));
        }
        
        if (request('search')) {
            $query->where('name', 'like', '%' . request('search') . '%');
        }
        
        if (request('sort')) {
            switch (request('sort')) {
                case 'price_low':
                    $query->orderBy('price_unit', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price_unit', 'desc');
                    break;
                case 'popular':
                    $query->orderBy('stock', 'desc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }
        
        if (request('in_stock')) {
            $query->where('stock', '>', 0);
        }
        
        $products = $query->paginate(20);
        
        return view('products.index', compact('products', 'categories'));
    }
    
    /**
     * Public Product Detail - Accessible without login
     */
    public function publicShow(Product $product)
    {
        $product->load('category');
        $relatedProducts = Product::where('category_id', $product->category_id)
                                  ->where('id', '!=', $product->id)
                                  ->limit(4)
                                  ->get();
        
        return view('products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Customer Products Index - Requires login
     */
    public function index()
    {
        $categories = Category::all();
        $query = Product::with('category');
        
        if (request('category')) {
            $query->where('category_id', request('category'));
        }
        
        if (request('search')) {
            $query->where('name', 'like', '%' . request('search') . '%');
        }
        
        $products = $query->paginate(12);
        
        return view('customer.products.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        $relatedProducts = Product::where('category_id', $product->category_id)
                                  ->where('id', '!=', $id)
                                  ->limit(4)
                                  ->get();
        
        return view('customer.products.show', compact('product', 'relatedProducts'));
    }
}

<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
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

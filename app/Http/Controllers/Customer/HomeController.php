<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\StoreSetting;
use App\Models\Order;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $latestProducts = Product::latest()->limit(6)->get();
        $bestSellingProducts = Product::inRandomOrder()->limit(6)->get();
        $categories = Category::all();
        $storeSetting = StoreSetting::first();
        
        return view('customer.home', compact(
            'latestProducts',
            'bestSellingProducts', 
            'categories',
            'storeSetting'
        ));
    }

    public function about()
    {
        $storeSetting = StoreSetting::first();
        return view('customer.about', compact('storeSetting'));
    }

    public function dashboard()
    {
        $orders = auth()->user()->orders()->latest()->get();
        $totalOrders = $orders->count();
        $totalSpent = $orders->sum('total_price');
        
        return view('customer.dashboard', compact('orders', 'totalOrders', 'totalSpent'));
    }

    public function orders()
    {
        $orders = auth()->user()->orders()->latest()->paginate(10);
        return view('customer.orders', compact('orders'));
    }
}

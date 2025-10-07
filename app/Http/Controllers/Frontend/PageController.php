<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('frontend.pages.about');
    }

    public function contact()
    {
        return view('frontend.pages.contact');
    }

    public function faq()
    {
        return view('frontend.pages.faq');
    }

    public function shipping()
    {
        return view('frontend.pages.shipping');
    }

    public function payment()
    {
        return view('frontend.pages.payment');
    }

    public function return()
    {
        return view('frontend.pages.return');
    }

    public function privacy()
    {
        return view('frontend.pages.privacy');
    }

    public function categories()
    {
        $categories = Category::withCount('products')
            ->whereHas('products')
            ->orderBy('name')
            ->get();

        return view('frontend.pages.categories', compact('categories'));
    }

    public function profile()
    {
        return view('frontend.pages.profile');
    }

    public function orders()
    {
        $orders = auth()->user()->orders()->with('items.product')->latest()->paginate(10);
        return view('frontend.pages.orders', compact('orders'));
    }

    public function orderDetail($order)
    {
        $order = auth()->user()->orders()->with('items.product')->findOrFail($order);
        return view('frontend.pages.order-detail', compact('order'));
    }

    public function addresses()
    {
        $addresses = auth()->user()->addresses()->latest()->get();
        return view('frontend.pages.addresses', compact('addresses'));
    }
}
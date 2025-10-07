<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = \App\Models\Product::where('is_featured', true)->latest()->take(4)->get();
        $newestProducts = \App\Models\Product::latest()->take(4)->get();

        return view('frontend.home', compact('featuredProducts', 'newestProducts'));
    }
}

<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the owner dashboard view.
     */
    public function index(): View
    {
        return view('owner.dashboard');
    }
}

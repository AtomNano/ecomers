<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Method untuk menampilkan halaman home
    public function index()
    {
        return view('home'); // 'home' adalah nama file view yang akan kita buat
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $topProducts = Product::orderByDesc('sustainable_rating')->take(3)->get();
        $topSearchedProducts = Product::orderByDesc('search_count')->take(10)->get();

        return view('admin.dashboard', compact('topProducts', 'topSearchedProducts'));
    }
}


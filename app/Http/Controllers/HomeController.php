<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     */
    public function home()
    {
        $topProducts = Product::orderByDesc('sustainable_rating')
                        ->take(3)
                        ->get();

        return view('home', compact('topProducts'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ScanController extends Controller
{
    // This is the method the route should call
    public function index()
    {
    }

    public function handle(Request $request)
{
    $barcode = $request->input('barcode');
    $product = Product::where('barcode', $barcode)->first();

    if ($product) {
        if (auth()->user()->is_admin) {
            return response()->json([
                'redirect' => route('admin.products.create', ['barcode' => $barcode])
            ]);
        } else {
            return response()->json([
                'redirect' => route('products.show', $product->id)
            ]);
        }
    } else {
        return response()->json(['error' => 'Product not found.']);
    }
}


}


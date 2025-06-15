<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
{
    $products = Product::all();
    return view('products.index', compact('products'));
}
    public function show($id, Request $request)
{
    $product = Product::with('reviews.user')->findOrFail($id);

    // Get filter inputs from the query string
    $minPrice = $request->query('min_price');
    $maxPrice = $request->query('max_price');

    // Query for recommended products (same category, not the current product)
    $recommendedQuery = Product::where('category', $product->category)
                               ->where('id', '!=', $product->id);

    if ($minPrice !== null) {
        $recommendedQuery->where('price', '>=', $minPrice);
    }

    if ($maxPrice !== null) {
        $recommendedQuery->where('price', '<=', $maxPrice);
    }

     $recommendedProducts = Product::where('id', '!=', $product->id)
        ->where('category', $product->category) // same category
        ->whereBetween('sustainable_rating', [
            $product->sustainable_rating - 30,
            $product->sustainable_rating + 30
        ])
        ->inRandomOrder()
        ->take(4)
        ->get();

    return view('products.show', compact('product', 'recommendedProducts'));
}


public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Get uploaded image
    $image = $request->file('image');

    // Generate a unique file name
    $imageName = time() . '_' . $image->getClientOriginalName();

    // Move the image to public/images/
    $image->move(public_path('images'), $imageName);

    // Save to database
    Product::create([
        'name' => $request->name,
        'image_path' => $imageName,
    ]);

    return redirect()->route('products.index')->with('success', 'Product created successfully!');
}

public function search(Request $request)
{
    $barcode = $request->query('barcode');

$product = Product::where('barcode', $barcode)->first();

if (!$product) {
    return redirect()->route('products.index')->with('scan_error', 'Product not found.');
}

if (auth()->check()) {
    auth()->user()->productHistories()->create([
        'product_id' => $product->id,
        'scanned_at' => now(),
    ]);
}

return redirect()->route('products.show', $product->id);

}

public function searchForm(Request $request)
{
    $query = $request->input('query');

    if (!$query) {
        return view('search'); // Just return search form view
    }

    // Search by name, brand, or barcode
    $products = Product::where('name', 'like', "%{$query}%")
        ->orWhere('brand', 'like', "%{$query}%")
        ->orWhere('barcode', 'like', "%{$query}%")
        ->get();

    return view('search-results', compact('products', 'query'));
}

// handles the actual search
public function searchResults(Request $request)
{
    $query = $request->input('query');

    $products = Product::where('name', 'LIKE', "%{$query}%")
                    ->orWhere('brand', 'LIKE', "%{$query}%")
                    ->orWhere('category', 'LIKE', "%{$query}%")
                    ->get();

    if ($products->isEmpty()) {
        return redirect()->back()->with('error', 'No matching products found.');
    }

    return view('search-results', compact('products'));
}

}

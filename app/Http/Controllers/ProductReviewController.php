<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductReview;

class ProductReviewController extends Controller
{
    public function store(Request $request, $productId)
{
    $validated = $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'review' => 'required|string',
        'is_anonymous' => 'nullable|boolean',
    ]);

    $product->reviews()->create([
        'user_id' => auth()->id(),
        'rating' => $validated['rating'],
        'review' => $validated['review'],
        'is_anonymous' => $request->has('is_anonymous'),
    ]);

    return redirect()->route('products.show', $product->id)->with('success', 'Review submitted successfully!');
}

public function show($id)
{
    $product = Product::with('reviews.user')->findOrFail($id);

    // Example recommended products logic
    $recommendedProducts = Product::where('category', $product->category)
                            ->where('id', '!=', $product->id)
                            ->take(4)->get();

    return view('products.show', compact('product', 'recommendedProducts'));
}

}

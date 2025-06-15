<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\IngredientAnalysis;
use App\Models\ProductReview;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        if (Gate::allows('access-user')) {
            abort(403);
        }

        $products = Product::with('ingredientAnalyses')->get();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand' => 'required',
            'name' => 'required',
            'description' => 'required',
            'category' => 'required',
            'sustainable_rating' => 'required|integer|min:0|max:100',
            'animal_cruelty' => 'boolean',
            'price' => 'required|numeric',
            'barcode' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'shop_url' => 'nullable|url',

            'ingredients.*.ingredient' => 'required|string',
            'ingredients.*.function' => 'nullable|string',
            'ingredients.*.safety' => 'required|in:Worst,Bad,Okay,Good,Great!',
        ]);

        $product->shop_url = $request->input('shop_url');

        $data = $request->except('image', 'ingredients');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $data['image_path'] = $imagePath;
        }

        $product = Product::create($data);

        if ($request->has('ingredients')) {
            $product->ingredientAnalyses()->createMany($request->input('ingredients'));
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function edit(Product $product)
    {
        $product->load('ingredientAnalyses');

        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'brand' => 'required',
            'name' => 'required',
            'description' => 'required',
            'category' => 'required',
            'sustainable_rating' => 'required|integer|min:0|max:100',
            'animal_cruelty' => 'requiredboolean',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
            'shop_url' => 'nullable|url',

            'ingredients.*.id' => 'nullable|integer|exists:ingredients_analysis,id',
            'ingredients.*.ingredient' => 'required|string',
            'ingredients.*.function' => 'nullable|string',
            'ingredients.*.safety' => 'required|in:Worst,Bad,Okay,Good,Great!',
        ]);

        $product->shop_url = $request->input('shop_url');

        $data = $request->except('image', 'ingredients', 'new_ingredients');

        if ($request->hasFile('image')) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $data['image_path'] = $request->file('image')->store('images', 'public');
        }

        $product->update($data);

        if ($request->has('ingredients')) {
            foreach ($request->input('ingredients') as $ingredientData) {
                if (!empty($ingredientData['_delete'])) {
                    IngredientAnalysis::destroy($ingredientData['id']);
                } else {
                    IngredientAnalysis::where('id', $ingredientData['id'])->update([
                        'ingredient' => $ingredientData['ingredient'],
                        'function' => $ingredientData['function'],
                        'safety' => $ingredientData['safety'],
                    ]);
                }
            }
        }

        if ($request->has('new_ingredients')) {
            foreach ($request->input('new_ingredients') as $new) {
                if (!empty($new['ingredient']) && !empty($new['safety'])) {
                    $product->ingredientAnalyses()->create([
                        'ingredient' => $new['ingredient'],
                        'function' => $new['function'],
                        'safety' => $new['safety'],
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }

    public function search(Request $request)
{
    $barcode = $request->query('barcode');

    $product = Product::where('barcode', $barcode)->first();

    if (!$product) {
        return redirect()->route('user.dashboard')->with('error', 'Product not found.');
    }

    return redirect()->route('products.show', $product->id);
}


    public function searchResults(Request $request)
    {
        $keyword = $request->input('keyword');
        $products = Product::where('name', 'like', '%' . $keyword . '%')->get();

        return view('products.search-results', compact('products', 'keyword'));
    }

    public function show($id)
    {
        $product = Product::with(['ingredientAnalyses', 'reviews.user'])->findOrFail($id);

        ProductHistory::create([
            'user_id' => auth()->id(),  // or null if guest
            'product_id' => $product->id,
            'scanned_at' => now(),
        ]);

        $recommended = Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->take(3)
            ->get();

        return view('products.show', compact('product', 'recommended'));
    }
}

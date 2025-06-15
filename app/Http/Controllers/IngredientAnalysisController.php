<?php

namespace App\Http\Controllers;

use App\Models\IngredientAnalysis;
use App\Models\Product;
use Illuminate\Http\Request;

class IngredientAnalysisController extends Controller
{
    public function create(Product $product)
    {
        return view('admin.ingredients.create', compact('product'));
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'ingredient' => 'required',
            'function' => 'nullable',
            'safety' => 'required|in:Worst,Bad,Okay,Good,Great!',
        ]);

        $product->ingredients()->create($request->all());

        return redirect()->route('admin.products.edit', $product)->with('success', 'Ingredient added.');
    }

    public function destroy(Product $product, IngredientAnalysis $ingredient)
    {
        $ingredient->delete();
        return back()->with('success', 'Ingredient removed.');
    }
}

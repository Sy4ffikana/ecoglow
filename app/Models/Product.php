<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductReview;
use App\Models\IngredientAnalysis;
use App\Models\ProductHistory;

class Product extends Model
{
    protected $fillable = [
        'brand', 'name', 'description', 'category',
        'sustainable_rating', 'animal_cruelty', 'price', 'search_count', 'image_path', 'barcode'
    ];

    public function ingredientAnalyses()
    {
        return $this->hasMany(IngredientAnalysis::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function histories()
    {
        return $this->hasMany(ProductHistory::class);
    }
}

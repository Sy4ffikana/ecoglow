<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientAnalysis extends Model
{
    protected $table = 'ingredients_analysis';

    protected $fillable = ['product_id', 'ingredient', 'function', 'safety'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}


<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('image_path')->nullable(); 
        $table->string('brand');
        $table->string('name');
        $table->text('description');
        $table->string('category');
        $table->integer('sustainable_rating'); // Percentage (0–100)
        $table->boolean('animal_cruelty')->default(false); // true = cruelty-free
        $table->decimal('price', 8, 2);
        $table->integer('search_count')->default(0);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

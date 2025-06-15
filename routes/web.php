<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\ProductController as PublicProductController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\IngredientAnalysisController;
use App\Http\Controllers\ProductReviewController;

// 🌐 Public Routes
Route::get('/', fn () => view('welcome'));
Route::get('/home', [HomeController::class, 'home'])->name('home');

Auth::routes();

// 🛠️ Admin Routes (protected with middleware if needed)
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('products', AdminProductController::class);
});

// 👤 User Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::get('/user/profile', [UserController::class, 'edit'])->name('user.profile');
    Route::put('/user/profile', [UserController::class, 'update'])->name('user.profile.update');
});

// 📷 Scan Routes
Route::get('/scan', fn () => 'Scan feature coming soon!')->name('scan');
Route::post('/scan', [ScanController::class, 'handle'])->name('scan.handle');

// 🔍 Search Routes (🧠 using PublicProductController!)
Route::get('/search', [PublicProductController::class, 'searchForm'])->name('search'); // Form route name = 'search'
Route::get('/search/results', [PublicProductController::class, 'search'])->name('search.results');

// 🧪 Ingredient Analysis Routes
Route::prefix('products/{product}')->group(function () {
    Route::get('/ingredients/create', [IngredientAnalysisController::class, 'create'])->name('products.ingredients.create');
    Route::post('/ingredients', [IngredientAnalysisController::class, 'store'])->name('products.ingredients.store');
    Route::delete('/ingredients/{ingredient}', [IngredientAnalysisController::class, 'destroy'])->name('products.ingredients.destroy');
});

// 🛍️ Public Product Routes
Route::get('/products', [PublicProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [PublicProductController::class, 'show'])->name('products.show');

// ⭐ Product Review Submission
Route::post('/products/{product}/reviews', [ProductReviewController::class, 'store'])->name('product.reviews.store');

Route::get('/products/filter', [App\Http\Controllers\PublicProductController::class, 'filter'])->name('products.filter');

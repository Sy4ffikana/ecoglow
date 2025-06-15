@extends('layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
@endsection

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Edit Product</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="brand" class="form-label">Brand</label>
            <input type="text" name="brand" class="form-control" value="{{ old('brand', $product->brand) }}" required>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3" required>{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <input type="text" name="category" class="form-control" value="{{ old('category', $product->category) }}" required>
        </div>

        <div class="mb-3">
            <label for="sustainable_rating" class="form-label">Sustainable Rating (%)</label>
            <input type="number" name="sustainable_rating" class="form-control" value="{{ old('sustainable_rating', $product->sustainable_rating) }}" min="0" max="100" required>
        </div>

        <div class="form-check mb-3">
    <input type="hidden" name="is_cruelty_free" value="0"> <!-- Default when unchecked -->
    <input type="checkbox" name="is_cruelty_free" value="1" class="form-check-input" id="is_cruelty_free"
        {{ $product->is_cruelty_free ? 'checked' : '' }}>
    <label class="form-check-label" for="is_cruelty_free">Cruelty-Free</label>
</div>



        <div class="mb-3">
            <label for="price" class="form-label">Price (USD)</label>
            <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Product Image</label>
            <input type="file" name="image" class="form-control">
            @if($product->image_path)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="img-fluid">
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="shop_url" class="form-label">Online Shop URL</label>
            <input type="url" class="form-control" name="shop_url" id="shop_url" value="{{ old('shop_url', $product->shop_url ?? '') }}">
        </div>


        <h4>Edit Ingredients</h4>

<div id="ingredients-container">
    @foreach ($product->ingredientAnalyses as $index => $ingredient)
        <div class="ingredient-row row g-2 mb-2">
            <input type="hidden" name="ingredients[{{ $index }}][id]" value="{{ $ingredient->id }}">

            <div class="col-md-3">
                <input type="text" name="ingredients[{{ $index }}][ingredient]" class="form-control"
                    value="{{ $ingredient->ingredient }}" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="ingredients[{{ $index }}][function]" class="form-control"
                    value="{{ $ingredient->function }}">
            </div>
            <div class="col-md-3">
                <select name="ingredients[{{ $index }}][safety]" class="form-select" required>
                    @foreach (['Worst', 'Bad', 'Okay', 'Good', 'Great!'] as $option)
                        <option value="{{ $option }}" {{ $ingredient->safety == $option ? 'selected' : '' }}>
                            {{ $option }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox"
                        name="ingredients[{{ $index }}][_delete]" value="1">
                    <label class="form-check-label text-danger">
                        Remove
                    </label>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Add new ingredient area -->
<hr>
<h5>Add Ingredient (optional)</h5>
<div id="new-ingredients-container">
    <!-- Dynamically added here -->
</div>
<div class="mb-3">
    <button type="button" class="btn btn-outline-primary" onclick="addIngredient()">+ Add Ingredient</button>
</div>

<script>
    let newIndex = 0;

    function addIngredient() {
        const container = document.getElementById('new-ingredients-container');
        const html = `
            <div class="row g-2 mb-2">
                <div class="col-md-3">
                    <input type="text" name="new_ingredients[${newIndex}][ingredient]" class="form-control" placeholder="Ingredient" required>
                </div>
                <div class="col-md-3">
                    <input type="text" name="new_ingredients[${newIndex}][function]" class="form-control" placeholder="Function (optional)">
                </div>
                <div class="col-md-3">
                    <select name="new_ingredients[${newIndex}][safety]" class="form-select" required>
                        <option value="">Select Safety</option>
                        <option value="Worst">Worst</option>
                        <option value="Bad">Bad</option>
                        <option value="Okay">Okay</option>
                        <option value="Good">Good</option>
                        <option value="Great!">Great!</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-sm btn-danger" onclick="this.parentElement.parentElement.remove()">Remove</button>
                </div>
            </div>`;
        container.insertAdjacentHTML('beforeend', html);
        newIndex++;
    }
</script>


        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
</div>
@endsection

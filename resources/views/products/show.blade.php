@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row g-5 align-items-start">
        <!-- Left: Product Image -->
        <div class="col-md-5 text-center">
            <img src="{{ asset('storage/' . $product->image_path) }}" class="img-fluid rounded shadow" alt="{{ $product->name }}">
        </div>

        <!-- Right: Product Details -->
        <div class="col-md-7">
            <!-- Sustainability Meter -->
            <div class="mb-4">
                <h5 class="mb-2" style="font-family: Georgia; font-weight: bold;">🌿 Sustainability Score</h5>
                <div class="progress" style="height: 40px; border-radius: 20px; background-color: #f0f0f0;">
                    <div 
                        class="progress-bar" 
                        role="progressbar" 
                        style="width: {{ $product->sustainable_rating }}%;
                               background-color:
                                @if($product->sustainable_rating <= 20) #e74c3c
                                @elseif($product->sustainable_rating <= 40) #fd7e14
                                @elseif($product->sustainable_rating <= 60) #f6c23e
                                @elseif($product->sustainable_rating <= 80) #a2d39c
                                @else #28a745
                                @endif;
                               font-family: Georgia;
                               font-weight: bold;
                               font-size: 1.1rem;"
                        aria-valuenow="{{ $product->sustainable_rating }}" 
                        aria-valuemin="0" 
                        aria-valuemax="100">
                        {{ $product->sustainable_rating }}%
                    </div>
                </div>
            </div>

            <!-- Product Name & Brand -->
            <h2 style="font-family: Georgia; font-weight: bold;">{{ $product->brand }} - {{ $product->name }}</h2>

            <!-- Category -->
            <p class="text-muted" style="font-family: Georgia;"><strong>Category:</strong> {{ $product->category }}</p>

            <!-- Description -->
            <p style="font-family: Georgia;">{{ $product->description }}</p>

            <!-- Animal Cruelty Badge -->
            <div class="mt-3">
                @if ($product->animal_cruelty)
                    <span class="badge" style="background-color: #a3cfbb; color: #1e5631; font-size: 1rem; padding: 8px 16px; border-radius: 30px; font-family: Georgia;">
                        🐇 Cruelty-Free
                    </span>
                @else
                    <span class="badge" style="background-color: #f8d7da; color: #842029; font-size: 1rem; padding: 8px 16px; border-radius: 30px; font-family: Georgia;">
                        🧪 Tested on Animals
                    </span>
                @endif
            </div>
            @if ($product->shop_url)
                <a href="{{ $product->shop_url }}" class="btn btn-success mt-3" target="_blank">
                Buy on Online Shop
                </a>
            @endif
        </div>
    </div>
</div>


    {{-- Ingredient Analysis --}}
    <h4 class="mt-4">Ingredient Analysis</h4>

    @if ($product->ingredientAnalyses->isEmpty())
        <p class="text-muted">No ingredient data available for this product.</p>
    @else
        <ul class="list-group">
            @foreach ($product->ingredientAnalyses as $ingredient)
                <li class="list-group-item">
                    <strong>{{ $ingredient->ingredient }}</strong>
                    @if ($ingredient->function)
                        – <em>{{ $ingredient->function }}</em>
                    @endif
                    <span class="badge bg-secondary float-end">{{ $ingredient->safety }}</span>
                </li>
            @endforeach
        </ul>
    @endif



    {{-- Reviews Section --}}
    <div class="mb-5">
        <h4 style="font-family: Georgia;">Product Reviews</h4>

        {{-- Submit Review Form --}}
        @auth
        <form action="{{ route('product.reviews.store', $product->id) }}" method="POST" class="mb-4">
            @csrf

            <div class="mb-3">
                <label for="rating" class="form-label">Rating (1-5):</label>
                <select name="rating" id="rating" class="form-select w-25" required>
                    @for ($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                    @endfor
                </select>
            </div>

            <div class="mb-3">
                <label for="review" class="form-label">Your Review:</label>
                <textarea name="review" id="review" rows="3" class="form-control" required></textarea>
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" name="is_anonymous" id="is_anonymous" class="form-check-input">
                <label for="is_anonymous" class="form-check-label">Submit as Anonymous</label>
            </div>

            <button type="submit" class="btn btn-success">Submit Review</button>
        </form>
        @else
        <p><a href="{{ route('login') }}">Log in</a> to leave a review.</p>
        @endauth

        {{-- Display Reviews --}}
        @if ($product->reviews->count())
            @foreach ($product->reviews as $review)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <strong>{{ $review->is_anonymous ? 'Anonymous' : $review->user->name }}</strong>
                        <div class="text-warning">
                            {!! str_repeat('★', $review->rating) !!}{!! str_repeat('☆', 5 - $review->rating) !!}
                        </div>
                        <p class="mt-2">{{ $review->review }}</p>
                        <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            @endforeach
        @else
            <p>No reviews yet. Be the first to leave one!</p>
        @endif
    </div>

    <h4 style="font-family: Georgia;">You May Also Like</h4>
    <form method="GET" class="row mb-3" id="priceFilterForm">
    <div class="col-md-3">
        <label for="min_price">Min Price (RM)</label>
        <input type="number" name="min_price" id="min_price" class="form-control" value="{{ request('min_price') }}">
    </div>
    <div class="col-md-3">
        <label for="max_price">Max Price (RM)</label>
        <input type="number" name="max_price" id="max_price" class="form-control" value="{{ request('max_price') }}">
    </div>
    <div class="col-md-3 d-flex align-items-end">
        <button type="submit" class="btn btn-outline-success w-100">Filter Recommendations</button>
    </div>
</form>

    {{-- Recommendations Section --}}
    <div class="mb-5">
    <div class="row">
        @if($recommendedProducts->count())
    <h5 class="mt-5 mb-3" style="font-family: 'Georgia';">You might also like:</h5>
    <div class="row">
        @foreach($recommendedProducts as $rec)
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100 shadow-sm">
                    @if($rec->image_path)
                        <img src="{{ asset('storage/' . $rec->image_path) }}" class="card-img-top" alt="{{ $rec->name }}" style="height: 150px; object-fit: cover;">
                    @endif
                    <div class="card-body text-center" style="font-family: 'Georgia';">
                        <h6 class="card-title mb-1">{{ $rec->brand }}</h6>
                        <p class="card-text text-muted" style="font-size: 14px;">{{ $rec->name }}</p>
                        <small class="text-muted">Rating: {{ $rec->sustainable_rating }}/100</small><br>
                        <a href="{{ route('products.show', $rec->id) }}" class="btn btn-outline-success btn-sm mt-2">View Product</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

    </div>
</div>

@endsection

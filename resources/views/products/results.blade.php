@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Product Found</h2>

    <div class="card mb-3">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="{{ asset('storage/' . $product->image_path) }}" class="img-fluid rounded-start" alt="Product Image">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->brand }} - {{ $product->name }}</h5>
                    <p class="card-text">{{ $product->description }}</p>
                    <p class="card-text"><strong>Category:</strong> {{ $product->category }}</p>
                    <p class="card-text"><strong>Price:</strong> RM {{ number_format($product->price, 2) }}</p>
                    <p class="card-text"><strong>Sustainability Rating:</strong> {{ $product->sustainable_rating }}%</p>
                    <p class="card-text"><strong>Cruelty Free:</strong> {{ $product->animal_cruelty ? 'Yes' : 'No' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

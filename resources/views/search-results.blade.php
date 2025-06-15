@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Search Results for: <em>{{ $query }}</em></h2>

    @if($products->isEmpty())
        <div class="alert alert-warning">
            No products found matching your search.
        </div>
    @else
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset('storage/' . $product->image_path) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text"><strong>Brand:</strong> {{ $product->brand }}</p>
                            <p class="card-text"><strong>Category:</strong> {{ $product->category }}</p>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-success btn-sm">View Product</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

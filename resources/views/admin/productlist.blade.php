@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4" style="font-family: 'Georgia';">Top 10 Most Searched Products</h2>
    
    <div class="table-responsive bg-white p-4 rounded shadow-sm">
        <table class="table table-hover">
            <thead style="background-color: #d8f3dc;">
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Search Count</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $index => $product)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->search_count }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No products found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

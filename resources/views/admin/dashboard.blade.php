@extends('layouts.app')

@section('content')
<style>
    .dashboard-top-products {
    text-align: center;
    margin-top: 30px;
    padding: 0 15px;
}

.dashboard-top-products h2 {
    font-family: 'Georgia', serif;
    font-size: 28px;
    margin-bottom: 25px;
    color: #2f4f2f;
}

.dashboard-podium {
    display: flex;
    justify-content: center;
    align-items: flex-end;
    gap: 20px;
    flex-wrap: wrap;
    margin-bottom: 40px;
}

.dashboard-place {
    width: 140px;
    background-color: #f0fdf4;
    border-radius: 20px 20px 0 0;
    padding: 12px 10px;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    font-family: 'Georgia', serif;
    transition: transform 0.3s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    min-height: 240px; /* prevent cutoff */
}

.dashboard-place:hover {
    transform: translateY(-5px);
}

.dashboard-place img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 10px;
    background-color: white;
    padding: 4px;
    margin-bottom: 8px;
}

.dashboard-first { margin-top: 0; }
.dashboard-second { margin-top: 40px; }
.dashboard-third { margin-top: 60px; }


.dashboard-place meter {
    width: 100%;
    height: 10px;
    display: block;
    margin-top: 4px;
    margin-bottom: 2px;
}

.dashboard-place .brand {
    font-weight: bold;
    font-size: 14px;
}

.dashboard-place .name {
    font-size: 12px;
    margin-bottom: 4px;
}

.dashboard-place .rating {
    font-size: 11px;
    color: #555;
}

@media (max-width: 768px) {
    .dashboard-podium {
        flex-direction: column;
        align-items: center;
    }

    .dashboard-place {
        width: 80%;
        min-height: auto;
        margin-bottom: 20px;
    }
}

    .scan-list {
        background-color: rgba(255,255,255,0.8);
        border-radius: 12px;
        padding: 20px;
        font-family: 'Georgia', serif;
    }

    .scan-list h4 {
        margin-bottom: 15px;
    }

    .scan-list ul {
        list-style: none;
        padding-left: 0;
    }

    .scan-list li {
        padding: 8px 0;
        border-bottom: 1px solid #c3e6cb;
    }
</style>

<div class="container mt-4">
    <h4 class="text-center mb-4" style="font-family: 'Georgia';">🏆 Top 3 Sustainable Products This Week</h4>
<div class="dashboard-podium">
    @php
    $positions = [
        1 => ['class' => 'dashboard-second', 'medal' => '🥈'],
        0 => ['class' => 'dashboard-first', 'medal' => '🥇'],
        2 => ['class' => 'dashboard-third', 'medal' => '🥉'],
    ];
@endphp

@foreach ([1, 0, 2] as $order)
    @if (isset($topProducts[$order]))
        @php
            $product = $topProducts[$order];
            $placeClass = $positions[$order]['class'];
            $medal = $positions[$order]['medal'];
        @endphp
        <div class="dashboard-place {{ $placeClass }}">
            <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none text-dark">
                <div class="text-center" style="font-size: 20px;">{{ $medal }}</div>

                @if ($product->image_path)
                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}">
                @endif

                <div class="mt-2" style="padding: 0 5px;">
                    <div style="font-weight: bold;">{{ $product->brand }}</div>
                    <div style="font-size: 13px;">{{ $product->name }}</div>
                    <meter min="0" max="100" value="{{ $product->sustainable_rating }}" style="width: 100%;"></meter>
                    <div class="text-muted" style="font-size: 12px;">{{ $product->sustainable_rating }}/100</div>
                </div>
            </a>
        </div>
    @endif
@endforeach

</div>
</div>

   <div class="scan-list mt-5">
    <h4>Top 10 Most Searched Products</h4>

    @if($topSearchedProducts->isNotEmpty())
        <div class="table-responsive">
            <table class="table table-striped table-bordered" style="font-family: 'Georgia'; background-color: #ffffffb8;">
                <thead class="table-success">
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th>Product</th>
                        <th style="width: 20%;" class="text-end">Search Count</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($topSearchedProducts as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none text-dark">
                                    {{ $product->brand }} - {{ $product->name }}
                                </a>
                            </td>
                            <td class="text-end">{{ $product->search_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>No search data available yet.</p>
    @endif
</div>


@endsection

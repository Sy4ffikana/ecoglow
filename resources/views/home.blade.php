@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #e6f2e6;
        font-family: 'Georgia', serif;
        color: #2f2f2f;
        margin: 0;
        padding: 0;
    }

    .top-products {
        text-align: center;
        margin-top: 40px;
        padding: 0 15px;
    }

    .top-products h2 {
        font-size: 28px;
        margin-bottom: 20px;
        color: #2f4f2f;
    }

    .podium {
        display: flex;
        justify-content: center;
        align-items: flex-end;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 40px;
    }

    .place {
    width: 160px;
    background-color: #d4ead8;
    border-radius: 20px 20px 0 0;
    padding: 10px;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    font-family: 'Georgia', serif;
    transition: transform 0.3s ease;
    display: flex;
    flex-direction: column;
    justify-content: flex-start; /* change from flex-end to flex-start */
    align-items: center;
    min-height: 240px; /* use min-height instead of fixed height */
    position: relative;
    overflow: visible;
}

    .place:hover {
        transform: translateY(-5px);
    }

    .first { min-height: 240px; }
.second { min-height: 220px; }
.third { min-height: 200px; }

    .place a {
    color: inherit;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    height: 100%;
    width: 100%;
}

   .place img {
    max-height: 80px;
    width: 80px;
    object-fit: contain;
    margin-bottom: 5px;
    border-radius: 10px;
    background-color: white;
    padding: 5px;
}

    .product-brand {
    font-weight: bold;
    font-size: 14px;
    margin-top: 5px;
    text-align: center;
}

.product-name {
    font-size: 12px;
    margin: 2px 0 4px;
    text-align: center;
}

.product-rating {
    font-size: 11px;
    color: #555;
    text-align: center;
}

.place meter {
    width: 100%;
    height: 10px;
    margin: 4px 0;
    display: block;
}

    /* Info section */
    .info-section {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: flex-start;
        padding: 40px 20px;
        gap: 40px;
        background-color: #f5fdf6;
        border-radius: 30px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.05);
        margin: 0 auto 60px auto;
        max-width: 1100px;
    }

    .infographic img {
        max-width: 400px;
        width: 100%;
        height: auto;
        border-radius: 20px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .eco-info {
        max-width: 500px;
        line-height: 1.8;
        font-size: 17px;
        font-family: 'Georgia', serif;
        color: #2f2f2f;
    }

    .eco-info h3 {
        font-size: 26px;
        margin-bottom: 15px;
        font-weight: 600;
        color: #3c614b;
    }

    .continue-section {
        text-align: center;
        margin-bottom: 80px;
        font-size: 18px;
    }

    .continue-section a {
        display: inline-block;
        margin-top: 10px;
        padding: 12px 28px;
        background-color: #8cc8a3;
        color: white;
        text-decoration: none;
        border-radius: 25px;
        font-weight: bold;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }

    .continue-section a:hover {
        background-color: #6fad87;
    }

    @media (max-width: 768px) {
        .podium {
            flex-direction: column;
            align-items: center;
        }

        .place {
            width: 80%;
            height: auto !important;
        }

        .info-section {
            flex-direction: column;
            align-items: center;
        }

        .eco-info {
            text-align: center;
        }
        .info-section {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .infographic img {
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            height: auto;
        }

        .equal-height {
            height: 250px; /* or whatever height you prefer */
            object-fit: contain;
        }

        .small-width {
            width: auto;
        }
    }
</style>

<div class="top-products">
    <h2>🏆 Top 3 Sustainable Products This Week</h2>
    <div class="podium">
        @foreach ($topProducts as $index => $product)
            @php
                $placeClass = ['second', 'first', 'third'][$index];
                $medal = ['🥈', '🥇', '🥉'][$index];
            @endphp
            <div class="place {{ $placeClass }}">
                <a href="{{ route('products.show', $product->id) }}">
                    <div style="font-size: 20px;">{{ $medal }}</div>
                    @if ($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}">
                    @endif
                    <div class="product-brand">{{ $product->brand }}</div>
                    <div class="product-name">{{ $product->name }}</div>
                    <meter min="0" max="100" value="{{ $product->sustainable_rating }}"></meter>
                    <div class="product-rating">{{ $product->sustainable_rating }}/100</div>
                </a>
            </div>
        @endforeach
    </div>
</div>

<div class="info-section d-flex justify-content-center align-items-center gap-4 mt-4 flex-wrap">
    <div class="infographic">
        <img src="{{ asset('images/infographic1.jpg') }}" alt="Infographic 1" class="equal-height small-width">
    </div>
    <div class="infographic">
        <img src="{{ asset('images/infographic.png') }}" alt="Infographic 2" class="equal-height">
    </div>
</div>

    <div class="eco-info">
        <h3>About EcoGlow</h3>
        <p>
            EcoGlow is your companion for conscious beauty choices. We evaluate product ingredients, packaging, and ethical practices to provide an environmental score — empowering you to choose sustainability without compromising style. 🌱
        </p>
        <p>
            Join the movement for a cleaner planet by making smart, informed decisions with EcoGlow.
        </p>
    </div>
</div>

<div class="continue-section">
    <p>To continue:</p>
    <a href="{{ route('login') }}">Log In</a>
</div>
@endsection

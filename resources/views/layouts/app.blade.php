<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'EcoGlow')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Bootstrap (Optional for other components) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Playfair Display', serif;
            background-color: #e6f2e6;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #cde0cd;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-left img {
            height: 55px;
            cursor: pointer;
        }

        .header-right {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: center;
        }

        .header-right a {
            text-decoration: none;
            color: #2e4d2e;
            font-weight: bold;
            padding: 6px 12px;
            border-radius: 5px;
            transition: background-color 0.2s ease;
        }

        .header-right a:hover {
            background-color: #d2e3d2;
        }

    .breadcrumb {
        background-color: #d2e3d2;
        font-weight: 500;
        font-size: 0.95rem;
        border-radius: 0.5rem;
    }
    .breadcrumb a {
        color: #4a7c59;
        text-decoration: none;
    }
    .breadcrumb-item.active {
        color: #2e4d3a;
    }
    /* Add these custom styles below your Bootstrap import or inside a <style> block in the Blade file */

.bg-meter-red {
    background-color: #f25f5c !important;
}

.bg-meter-orange {
    background-color: #f89c5b !important;
}

.bg-meter-yellow {
    background-color: #ffe066 !important;
    color: #333 !important;
}

.bg-meter-yellowgreen {
    background-color: #c0e57c !important;
    color: #333 !important;
}

.bg-meter-green {
    background-color: #7bd389 !important;
}

        @media (max-width: 768px) {
            header {
                flex-direction: column;
                align-items: flex-start;
            }

            .header-right {
                width: 100%;
                justify-content: flex-start;
                margin-top: 10px;
            }
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- Global Header -->
    <header class="navbar navbar-expand-lg" style="background-color: #b2c8b2; font-family: 'Georgia', serif; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
    <div class="container-fluid py-2 px-4 d-flex justify-content-between align-items-center">

        {{-- Logo redirects to user dashboard if user, else home --}}
        <a class="navbar-brand d-flex align-items-center" href="{{ Auth::check() && Auth::user()->is_admin == 0 ? route('user.dashboard') : route('admin.dashboard') }}">
            <img src="{{ asset('images/header.png') }}" alt="EcoGlow Logo" style="height: 50px;" class="me-2">
        </a>

        {{-- Search bar (only for user) --}}
        @auth
            @if(Auth::check())
    <form action="{{ route('search') }}" method="GET" class="flex-grow-1 mx-4">
        <input 
            type="text" 
            name="query" 
            class="form-control shadow-sm"
            placeholder="Search..." 
            style="
                background-color: #f0fff0;
                border: 1px solid #cde8d6;
                border-radius: 12px;
                font-family: 'Georgia', serif;
                padding: 0.5rem 1rem;
            "
            required
        >
    </form>
@endif

        @endauth

        {{-- Navigation buttons --}}
        <div class="d-flex align-items-center gap-3">
            @auth
                @if (Auth::user()->is_admin == 0)
                    <a href="{{ route('user.dashboard') }}" style="background: none; border: none; color: #2d4d3a; font-weight: bold; font-family: 'Georgia'; text-decoration: none;">Home</a>
                    <a href="{{ route('user.profile') }}" style="background: none; border: none; color: #2d4d3a; font-weight: bold; font-family: 'Georgia'; text-decoration: none;">Profile</a>
                @else
                    <a href="{{ route('admin.dashboard') }}" style="background: none; border: none; color: #2d4d3a; font-weight: bold; font-family: 'Georgia'; text-decoration: none;">Home</a>
                    <a href="{{ route('admin.products.index') }}" style="background: none; border: none; color: #2d4d3a; font-weight: bold; font-family: 'Georgia'; text-decoration: none;">Products</a>
                @endif
                <a href="{{ route('logout') }}" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   style="background: none; border: none; color: #8b0000; font-weight: bold; font-family: 'Georgia'; text-decoration: none;">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            @else
                <a href="{{ route('login') }}" style="background: none; border: none; color: #2d4d3a; font-weight: bold; font-family: 'Georgia'; text-decoration: none;">Login</a>
            @endauth
        </div>
    </div>
</header>
@auth
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb mb-0">
            @php
                $user = Auth::user();
                $previous = url()->previous();
                $current = request()->path();
                $segments = explode('/', $current);
                $currentPage = ucfirst(end($segments));
            @endphp

            {{-- 🏠 Dashboard --}}
            <li class="breadcrumb-item">
                <a href="{{ $user->is_admin ? route('admin.dashboard') : route('user.dashboard') }}">
                    Home
                </a>
            </li>

            {{-- 📦 Products or other base paths --}}
            @if(Str::contains($current, 'products'))
                <li class="breadcrumb-item">
                    <a href="{{ $user->is_admin ? route('admin.products.index') : route('products.index') }}">
                        Products
                    </a>
                </li>
            @endif

            {{-- 🔙 Back link --}}
            <li class="breadcrumb-item">
                <a href="{{ $previous }}">← Back</a>
            </li>

            {{-- 📍 Current page --}}
            <li class="breadcrumb-item active" aria-current="page">
                {{ ucwords(str_replace('-', ' ', $currentPage)) }}
            </li>
        </ol>
    </nav>
@endauth

    <!-- Main Content -->
    <main class="container py-4">
        @yield('content')
    </main>

    @stack('scripts')
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#6ab04c',
        });
    </script>
@endif

</body>
</html>

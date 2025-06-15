@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #e6f2e6; /* Pastel green */
        font-family: 'Georgia', serif;
        color: #333;
    }

    .login-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 85vh;
        gap: 60px;
        padding: 40px 20px;
        flex-wrap: wrap;
    }

    .login-image {
        text-align: center;
    }

    .login-image img {
        width: 320px;
        height: auto;
    }

    .login-image p {
        margin-top: 20px;
        font-size: 20px;
        font-style: italic;
        color: #3c614b;
    }

    .login-container {
        background-color: rgba(255, 255, 255, 0.85);
        padding: 35px 45px;
        border-radius: 20px;
        width: 100%;
        max-width: 400px;
    }

    .login-container h2 {
        text-align: center;
        margin-bottom: 25px;
        font-family: 'Georgia', serif;
        font-size: 26px;
        font-weight: bold;
    }

    .form-control {
        border-radius: 10px;
        padding: 10px;
    }

    .btn-login {
        width: 100%;
        background-color: #8cc8a3;
        color: white;
        border: none;
        padding: 12px;
        border-radius: 10px;
        margin-top: 20px;
        font-weight: bold;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }

    .btn-login:hover {
        background-color: #6fad87;
    }

    .login-links {
        margin-top: 18px;
        text-align: center;
    }

    .login-links a {
        color: #3c614b;
        margin: 0 12px;
        text-decoration: none;
        font-size: 15px;
        font-weight: 500;
    }

    .login-links a:hover {
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .login-wrapper {
            flex-direction: column;
            text-align: center;
        }

        .login-image img {
            width: 250px;
        }
    }
</style>

<div class="login-wrapper">
    <div class="login-image">
        <img src="{{ asset('images/header.png') }}" alt="EcoGlow Logo">
        <p>Make the changes with us</p>
    </div>

    <div class="login-container">
        <h2>Login</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input id="email" type="email" class="form-control" name="email" required autofocus>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" class="form-control" name="password" required>
            </div>

            <button type="submit" class="btn btn-login">
                Log In
            </button>

            <div class="login-links">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">Forgot Password?</a>
                @endif

                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Sign Up</a>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection

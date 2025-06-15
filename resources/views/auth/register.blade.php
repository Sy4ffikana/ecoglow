@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #e6f2e6; /* Pastel green */
        font-family: 'Georgia', serif;
        color: #333;
    }

    .register-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 85vh;
        gap: 60px;
        padding: 40px 20px;
        flex-wrap: wrap;
    }

    .register-image {
        text-align: center;
    }

    .register-image img {
        width: 320px;
        height: auto;
    }

    .register-image p {
        margin-top: 20px;
        font-size: 20px;
        font-style: italic;
        color: #3c614b;
    }

    .register-container {
        background-color: rgba(255, 255, 255, 0.85);
        padding: 35px 45px;
        border-radius: 20px;
        width: 100%;
        max-width: 450px;
    }

    .register-container h2 {
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

    .btn-register {
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

    .btn-register:hover {
        background-color: #6fad87;
    }

    .register-links {
        margin-top: 18px;
        text-align: center;
    }

    .register-links a {
        color: #3c614b;
        text-decoration: none;
        font-size: 15px;
        font-weight: 500;
    }

    .register-links a:hover {
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .register-wrapper {
            flex-direction: column;
            text-align: center;
        }

        .register-image img {
            width: 250px;
        }
    }
</style>

<div class="register-wrapper">
    <div class="register-image">
        <img src="{{ asset('images/header.png') }}" alt="EcoGlow Logo">
        <p>Make the changes with us</p>
    </div>

    <div class="register-container">
        <h2>Sign Up</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input id="name" type="text" class="form-control" name="name" required autofocus>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input id="email" type="email" class="form-control" name="email" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" class="form-control" name="password" required>
            </div>

            <div class="mb-3">
                <label for="password-confirm" class="form-label">Confirm Password</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-register">
                Register
            </button>

            <div class="register-links mt-3">
                <a href="{{ route('login') }}">Already have an account? Log In</a>
            </div>
        </form>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #e6f2e6; /* Pastel green */
        font-family: 'Georgia', serif;
        color: #333;
    }

    .forgot-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 85vh;
        gap: 60px;
        padding: 40px 20px;
        flex-wrap: wrap;
    }

    .forgot-image {
        text-align: center;
    }

    .forgot-image img {
        width: 320px;
        height: auto;
    }

    .forgot-image p {
        margin-top: 20px;
        font-size: 20px;
        font-style: italic;
        color: #3c614b;
    }

    .forgot-container {
        background-color: rgba(255, 255, 255, 0.85);
        padding: 35px 45px;
        border-radius: 20px;
        width: 100%;
        max-width: 450px;
    }

    .forgot-container h2 {
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

    .btn-reset {
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

    .btn-reset:hover {
        background-color: #6fad87;
    }

    .back-login {
        margin-top: 18px;
        text-align: center;
    }

    .back-login a {
        color: #3c614b;
        text-decoration: none;
        font-size: 15px;
        font-weight: 500;
    }

    .back-login a:hover {
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .forgot-wrapper {
            flex-direction: column;
            text-align: center;
        }

        .forgot-image img {
            width: 250px;
        }
    }
</style>

<div class="forgot-wrapper">
    <div class="forgot-image">
        <img src="{{ asset('images/header.png') }}" alt="EcoGlow Logo">
        <p>Make the changes with us</p>
    </div>

    <div class="forgot-container">
        <h2>Forgot Password</h2>

        @if (session('status'))
            <div class="alert alert-success text-center">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Enter your email address</label>
                <input id="email" type="email" class="form-control" name="email" required autofocus>
            </div>

            <button type="submit" class="btn btn-reset">
                Send Password Reset Link
            </button>

            <div class="back-login mt-3">
                <a href="{{ route('login') }}">Back to Login</a>
            </div>
        </form>
    </div>
</div>
@endsection

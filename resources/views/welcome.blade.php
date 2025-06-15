<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EcoGlow Splash</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            background-color: #e6f2e6; /* Pastel green */
            overflow: hidden;
            font-family: 'Segoe UI', sans-serif;
        }

        .splash-screen {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100vw;
            height: 100vh;
            animation: fadeInOut 3s ease-in-out forwards;
        }

        .splash-screen img {
            width: 60%;
            max-width: 300px;
            height: auto;
        }

        @keyframes fadeInOut {
            0% { opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { opacity: 0; }
        }
    </style>

    <script>
    setTimeout(function () {
        window.location.href = "{{ route('home') }}";
    }, 3000);
</script>
</head>
<body>
    <div class="splash-screen">
        <img src="{{ asset('images/header.png') }}" alt="EcoGlow Logo">
    </div>
</body>
</html>

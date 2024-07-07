<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hellomi')</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .rating-stars {
            display: inline-block;
            font-size: 24px;
        }
        .rating-stars .fa-star {
            color: #ddd; /* Warna outline */
            cursor: pointer;
        }
        .rating-stars .fa-star.checked {
            color: gold; /* Warna filled */
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>
<body>

<nav class="navbar">
    <div class="navbar-container">
        <div class="navbar-logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
        </div>
        <ul class="navbar-links">
            <!-- Common Links -->
            <li class="navbar-item {{ \Route::is('home') ? 'active' : '' }}">
                <a href="{{ url('/') }}">Beranda</a>
            </li>
            <li class="navbar-item {{ \Route::is('catalogue') ? 'active' : '' }}">
                <a href="{{ url('/katalog') }}">Katalog</a>
            </li>
            <li class="navbar-item {{ \Route::is('about') ? 'active' : '' }}">
                <a href="{{ url('/tentang-hellomi') }}">Tentang Hellomi</a>
            </li>

            <!-- Authenticated User Links -->
            @auth
                <li class="navbar-item {{ \Route::is('profile') ? 'active' : '' }}">
                    <a href="{{ url('/profil') }}">Profil</a>
                </li>
            @endauth
        </ul>
        <div class="navbar-login">
            @auth
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-logout">Logout</button>
                </form>
            @endauth
            @guest
                <a href="{{ url('/login') }}">Login</a>
            @endguest
        </div>
    </div>
</nav>

<div class="content">
    @yield('content')
</div>
</body>
</html>

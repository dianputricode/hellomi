<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hellomi Admin')</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
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
            <li class="navbar-item {{ \Route::is('dashboard') ? 'active' : '' }}">
                <a href="{{ url('/dashboard') }}">Dashboard</a>
            </li>
            <li class="navbar-item {{ \Route::is('view.rating') ? 'active' : '' }}">
                <a href="{{ url('/ratings') }}">Lihat Rating</a>
            </li>
            <li class="navbar-item {{ \Route::is('view.wishlist') ? 'active' : '' }}">
                <a href="{{ url('/wishlists') }}">Lihat Wishlist</a>
            </li>
            <li class="navbar-item {{ \Route::is('manage-products') ? 'active' : '' }}">
                <a href="{{ url('/kelola-produk') }}">Kelola Produk</a>
            </li>
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

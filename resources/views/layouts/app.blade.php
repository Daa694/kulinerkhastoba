<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Kuliner Khas Toba') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Logo Pulse & Rotate */
        @keyframes rotateLogo {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .logo-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pulse 4s ease-in-out infinite;
        }

        .logo-circle {
            position: absolute;
            width: 65px;
            height: 65px;
            border: 3px dashed #D2552D;
            border-radius: 50%;
            animation: rotateLogo 10s linear infinite;
            z-index: 0;
            opacity: 0.5;
        }

        .logo-keren {
            z-index: 1;
            height: 48px;
            width: 48px;
            border-radius: 9999px;
            transition: all 0.3s ease;
            box-shadow: 0 0 10px rgba(210, 85, 45, 0.4);
        }

        .logo-keren:hover {
            transform: scale(1.15);
            box-shadow: 0 0 25px rgba(210, 85, 45, 0.7);
            filter: brightness(1.1);
        }

        /* Loading */
        #preloader {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: #fff5e9;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.5s ease;
        }

        #preloader.hide {
            opacity: 0;
            visibility: hidden;
        }

        .dropdown-menu {
            display: none;
            transition: all 0.3s ease;
        }

        .dropdown-menu.show {
            display: block;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from { transform: translateY(-10px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 0;
            background-color: #D2552D;
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .search-input {
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .search-input:focus {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transform: translateY(-1px);
        }

        .cart-badge {
            transition: all 0.3s ease;
        }

        .cart-badge:hover {
            transform: scale(1.1);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-[#F6F0E7] to-[#FFF5E9] min-h-screen">

<!-- Loader -->
<div id="preloader">
    <div class="logo-wrapper">
        <div class="logo-circle"></div>
        <img src="{{ asset('images/tobataste.png') }}" alt="Loading" class="logo-keren">
    </div>
</div>

<!-- Navbar -->
<nav class="bg-gradient-to-r from-[#2E5A43] to-[#1f3d2d] shadow-lg sticky top-0 z-50">
    <div class="container mx-auto px-6">
        <div class="flex justify-between items-center py-4">
            <!-- Logo -->
            <div class="flex items-center space-x-4">
                <div class="logo-wrapper transform hover:scale-105 transition-transform duration-300">
                    <div class="logo-circle"></div>
                    <img src="{{ asset('images/tobataste.png') }}" alt="Logo" class="logo-keren">
                </div>
                <span class="text-white text-xl font-bold tracking-wide">Toba Taste</span>
            </div>

            <!-- Search -->
            <div class="flex-1 max-w-xl mx-8">
                <form action="{{ route('menu') }}" method="GET" class="relative group">
                    <input type="text" name="search" placeholder="Cari menu favorit Anda..."
                        class="search-input w-full px-6 py-3 rounded-full bg-white/95 text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#D2552D]/50 placeholder-gray-400">
                    <button type="submit"
                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-[#2E5A43] hover:text-[#D2552D]">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>

            <!-- Links -->
            <div class="flex items-center space-x-8">
                <a href="{{ route('menu') }}" class="nav-link text-white hover:text-[#D2552D] flex items-center space-x-2">
                    <i class="fas fa-utensils"></i><span>Menu</span>
                </a>
                <a href="{{ route('rekomendasi') }}" class="nav-link text-white hover:text-[#D2552D] flex items-center space-x-2">
                    <i class="fas fa-star"></i><span>Rekomendasi</span>
                </a>
                <a href="{{ route('about') }}" class="nav-link text-white hover:text-[#D2552D] flex items-center space-x-2">
                    <i class="fas fa-info-circle"></i><span>About</span>
                </a>
                <a href="{{ route('contact') }}" class="nav-link text-white hover:text-[#D2552D] flex items-center space-x-2">
                    <i class="fas fa-envelope"></i><span>Contact</span>
                </a>

                @auth
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="nav-link text-yellow-300 hover:text-yellow-400 flex items-center space-x-2 font-semibold">
                            <i class="fas fa-tachometer-alt"></i><span>Dashboard</span>
                        </a>
                        <a href="{{ route('admin.kuliner.index') }}" class="nav-link text-yellow-300 hover:text-yellow-400 flex items-center space-x-2 font-semibold">
                            <i class="fas fa-cogs"></i><span>Kelola Menu</span>
                        </a>
                    @endif
                @endauth

                <!-- Cart -->
                <a href="{{ route('cart.index') }}" class="nav-link text-white relative">
                    <div class="relative transform hover:scale-110">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <span class="cart-badge absolute -top-2 -right-2 bg-[#D2552D] text-white rounded-full w-5 h-5 flex items-center justify-center text-xs font-semibold shadow-lg">
                            {{ $cartCount ?? 0 }}
                        </span>
                    </div>
                </a>

                <!-- Profile -->
                <div class="relative dropdown">
                    <button onclick="toggleDropdown()" class="flex items-center space-x-3 text-white hover:text-[#D2552D]">
                        <i class="fas fa-user-circle text-2xl"></i>
                        @auth
                            <span>{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-sm"></i>
                        @endauth
                    </button>
                    <div id="userDropdown" class="dropdown-menu absolute right-0 mt-3 w-72 bg-white rounded-lg shadow-xl py-2 z-50">
                        @auth
                            <div class="px-6 py-4 border-b border-gray-100">
                                <div class="font-semibold text-lg text-gray-800 flex items-center">
                                    {{ Auth::user()->name }}
                                    @if(Auth::user()->isAdmin())
                                        <span class="ml-2 px-2 py-0.5 bg-yellow-400 text-xs text-gray-900 rounded-full font-bold">Admin</span>
                                    @endif
                                </div>
                                <div class="text-gray-600 text-sm">{{ Auth::user()->email }}</div>
                                <div class="text-gray-500 text-sm italic mt-1">
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    {{ Auth::user()->alamat_pengiriman ?? 'Belum diisi' }}
                                </div>
                            </div>
                            <div class="py-2">
                                <a href="{{ route('profil.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-user-edit w-5"></i><span class="ml-3">Edit Profil</span>
                                </a>
                                <a href="{{ route('orders.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-shopping-bag w-5"></i><span class="ml-3">Pesanan Saya</span>
                                </a>
                            </div>
                            <div class="border-t border-gray-100">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center px-6 py-3 text-gray-700 hover:bg-gray-50">
                                        <i class="fas fa-sign-out-alt w-5"></i><span class="ml-3">Logout</span>
                                    </button>
                                </form>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Konten -->
<main class="container mx-auto px-4 py-8">
    @yield('content')
</main>

<!-- Script -->
<script>
    // Preloader
    window.addEventListener('load', () => {
        document.getElementById('preloader').classList.add('hide');
    });

    // Dropdown
    function toggleDropdown() {
        const dropdown = document.getElementById('userDropdown');
        dropdown.classList.toggle('show');
    }

    window.onclick = function(event) {
        if (!event.target.closest('.dropdown')) {
            const dropdowns = document.getElementsByClassName('dropdown-menu');
            for (const d of dropdowns) d.classList.remove('show');
        }
    }
</script>

@stack('scripts')
<script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>

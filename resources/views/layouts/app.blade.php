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
    <!-- Navigation -->
    <nav class="bg-gradient-to-r from-[#2E5A43] to-[#1f3d2d] shadow-lg">
        <div class="container mx-auto">
            <div class="flex justify-between items-center py-4 px-6">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center transform hover:scale-105 transition-transform duration-300">
                        <img src="{{ asset('images/tobataste.png') }}" alt="Logo" class="h-12 w-12 rounded-full shadow-md">
                        <span class="text-white text-xl font-bold ml-3 tracking-wide">Toba Taste</span>
                    </div>
                </div>
                
                <!-- Search Bar -->
                <div class="flex-1 max-w-xl mx-8">
                    <form action="{{ route('menu') }}" method="GET" class="relative group">
                        <input type="text" name="search" placeholder="Cari menu favorit Anda..." 
                               class="search-input w-full px-6 py-3 rounded-full bg-white/95 text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#D2552D]/50 placeholder-gray-400">
                        <button type="submit" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-[#2E5A43] hover:text-[#D2552D] transition-colors duration-300">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>

                <!-- Navbar Items -->
                <div class="flex items-center space-x-8">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="nav-link text-white hover:text-[#D2552D] flex items-center space-x-2">
                                <i class="fas fa-tachometer-alt"></i>
                                <span>Dashboard</span>
                            </a>
                            <a href="{{ route('admin.kuliner.index') }}" class="nav-link text-white hover:text-[#D2552D] flex items-center space-x-2">
                                <i class="fas fa-list"></i>
                                <span>Kelola Menu</span>
                            </a>
                        @endif
                    @endauth
                    
                    <a href="{{ route('menu') }}" class="nav-link text-white hover:text-[#D2552D] flex items-center space-x-2">
                        <i class="fas fa-utensils"></i>
                        <span>Menu</span>
                    </a>
                    <a href="{{ route('rekomendasi') }}" class="nav-link text-white hover:text-[#D2552D] flex items-center space-x-2">
                        <i class="fas fa-star"></i>
                        <span>Rekomendasi</span>
                    </a>
                    <a href="{{ route('about') }}" class="nav-link text-white hover:text-[#D2552D] flex items-center space-x-2">
                        <i class="fas fa-info-circle"></i>
                        <span>About</span>
                    </a>
                    <a href="{{ route('contact') }}" class="nav-link text-white hover:text-[#D2552D] flex items-center space-x-2">
                        <i class="fas fa-envelope"></i>
                        <span>Contact</span>
                    </a>
                    
                    <a href="{{ route('cart.index') }}" class="nav-link text-white hover:text-[#D2552D] relative group">
                        <div class="relative transform hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-shopping-cart text-xl"></i>
                            <span class="cart-badge absolute -top-2 -right-2 bg-[#D2552D] text-white rounded-full w-5 h-5 flex items-center justify-center text-xs font-semibold shadow-lg group-hover:scale-110">
                                {{ $cartCount ?? 0 }}
                            </span>
                        </div>
                    </a>
                    
                    <!-- Profile Dropdown -->
                    <div class="relative dropdown">
                        <button onclick="toggleDropdown()" class="flex items-center space-x-3 text-white hover:text-[#D2552D] focus:outline-none transition-all duration-300 group">
                            <div class="relative">
                                <i class="fas fa-user-circle text-2xl group-hover:scale-110 transform transition-transform duration-300"></i>
                            </div>
                            @auth
                                <span class="font-medium">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-sm transition-transform duration-300 group-hover:rotate-180"></i>
                            @endauth
                        </button>
                        
                        <div id="userDropdown" class="dropdown-menu absolute right-0 mt-3 w-72 bg-white rounded-lg shadow-xl py-2 z-50">
                            @auth
                                <div class="px-6 py-4 border-b border-gray-100">
                                    <div class="font-semibold text-lg text-gray-800">{{ Auth::user()->name }}</div>
                                    <div class="text-gray-600 text-sm">{{ Auth::user()->email }}</div>
                                    <div class="text-gray-500 text-sm mt-2">{{ Auth::user()->address ?: 'Belum ada alamat' }}</div>
                                </div>
                                
                                <div class="py-2">
                                    <a href="{{ route('profil.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-50 hover:text-[#2E5A43] transition-colors duration-300">
                                        <i class="fas fa-user-edit w-5"></i>
                                        <span class="ml-3">Edit Profil</span>
                                    </a>
                                    <a href="{{ route('orders.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-50 hover:text-[#2E5A43] transition-colors duration-300">
                                        <i class="fas fa-shopping-bag w-5"></i>
                                        <span class="ml-3">Pesanan Saya</span>
                                    </a>
                                </div>
                                
                                <div class="border-t border-gray-100 mt-2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center px-6 py-3 text-gray-700 hover:bg-gray-50 hover:text-[#D2552D] transition-colors duration-300">
                                            <i class="fas fa-sign-out-alt w-5"></i>
                                            <span class="ml-3">Logout</span>
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

    <!-- Content -->
    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        window.onclick = function(event) {
            if (!event.target.matches('.dropdown button') && !event.target.matches('.dropdown button *')) {
                const dropdowns = document.getElementsByClassName('dropdown-menu');
                for (const dropdown of dropdowns) {
                    if (dropdown.classList.contains('show')) {
                        dropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
    
    @stack('scripts')
</body>
</html>

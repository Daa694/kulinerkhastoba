<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Toba Taste</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="flex bg-[#F6F0E7]">
    <!-- Sidebar -->
    <aside class="w-64 min-h-screen bg-[#2E5A43] text-white">
        <div class="p-4">
            <div class="flex items-center justify-center mb-8">
                <img src="{{ asset('images/tobataste.png') }}" alt="Logo" class="h-16">
            </div>
            
            <!-- Admin Profile Section -->
            <div class="mb-6 text-center">
                <div class="inline-block rounded-full bg-white p-2 mb-2">
                    <i class="fas fa-user-circle text-[#2E5A43] text-3xl"></i>
                </div>
                <h2 class="text-lg font-semibold">{{ Auth::user()->name }}</h2>
                <p class="text-sm text-gray-300">Administrator</p>
            </div>

            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded hover:bg-[#244934] {{ request()->routeIs('admin.dashboard') ? 'bg-[#244934]' : '' }}">
                    <i class="fas fa-home mr-2"></i> Dashboard
                </a>
                <a href="{{ route('admin.kuliner.index') }}" class="block px-4 py-2 rounded hover:bg-[#244934] {{ request()->routeIs('admin.kuliner.*') ? 'bg-[#244934]' : '' }}">
                    <i class="fas fa-list mr-2"></i> Kelola Menu
                </a>
                <a href="{{ route('menu') }}" class="block px-4 py-2 rounded hover:bg-[#244934]">
                    <i class="fas fa-utensils mr-2"></i> Lihat Menu
                </a>
                <a href="{{ route('admin.contact.messages') }}" class="block px-4 py-2 rounded hover:bg-[#244934] {{ request()->routeIs('admin.contact.messages') ? 'bg-[#244934]' : '' }}">
                    <i class="fas fa-envelope mr-2"></i> Pesan Kontak
                </a>
                <form action="{{ route('admin.logout') }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 text-left rounded hover:bg-[#D2552D]">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
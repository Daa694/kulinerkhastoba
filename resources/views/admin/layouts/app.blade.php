<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <!-- Sidebar -->
    <div class="fixed inset-y-0 left-0 w-64 bg-[#2E5A43] text-white">
        <div class="flex items-center justify-center h-16 border-b border-white/10">
            <h1 class="text-xl font-bold">Admin Dashboard</h1>
        </div>
        <nav class="mt-8">
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center px-6 py-3 text-gray-100 hover:bg-[#234434]">
                <i class="fas fa-tachometer-alt mr-3"></i>
                Dashboard
            </a>
            <a href="{{ route('admin.orders.index') }}" 
               class="flex items-center px-6 py-3 text-gray-100 hover:bg-[#234434]">
                <i class="fas fa-shopping-cart mr-3"></i>
                Pesanan
            </a>
            <a href="{{ route('admin.kuliner.index') }}" 
               class="flex items-center px-6 py-3 text-gray-100 hover:bg-[#234434]">
                <i class="fas fa-utensils mr-3"></i>
                Menu Kuliner
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="ml-64">
        <!-- Top Bar -->
        <div class="bg-white h-16 flex items-center justify-between px-6 border-b">
            <h2 class="text-xl font-semibold text-gray-800">{{ $title ?? 'Dashboard' }}</h2>
            <div class="flex items-center">
                <span class="mr-4 text-gray-600">{{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-gray-600 hover:text-gray-800">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Page Content -->
        <main class="p-6">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-[#2E5A43] mb-4">Menu Kuliner Khas Toba</h1>
        
        <!-- Search Form -->
        <form action="{{ route('menu.index') }}" method="GET" class="flex gap-4">
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}"
                   placeholder="Cari menu..." 
                   class="flex-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2E5A43]">
            <button type="submit" 
                    class="bg-[#2E5A43] text-white px-6 py-2 rounded-lg hover:bg-[#244934]">
                <i class="fas fa-search mr-2"></i> Cari
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($kuliners as $kuliner)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                @if($kuliner->gambar)
                    <img src="{{ asset('storage/' . $kuliner->gambar) }}" 
                         alt="{{ $kuliner->nama }}"
                         class="w-full h-48 object-cover">
                @endif
                
                <div class="p-4">
                    <h2 class="text-xl font-bold text-[#2E5A43] mb-2">{{ $kuliner->nama }}</h2>
                    <p class="text-gray-600 mb-4">{{ $kuliner->deskripsi }}</p>
                    
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-lg font-bold text-[#D2552D]">
                            {{ $kuliner->formatted_harga }}
                        </span>
                        <div class="flex items-center">
                            <span class="text-yellow-500 mr-1">
                                <i class="fas fa-star"></i>
                            </span>
                            <span>{{ number_format($kuliner->getAverageRating(), 1) }}</span>
                        </div>
                    </div>

                    @auth
                        @if($kuliner->tersedia && $kuliner->stok > 0)
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="kuliner_id" value="{{ $kuliner->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" 
                                        class="w-full bg-[#2E5A43] text-white px-4 py-2 rounded-lg hover:bg-[#244934]">
                                    <i class="fas fa-cart-plus mr-2"></i>Tambah ke Keranjang
                                </button>
                            </form>
                        @else
                            <button class="w-full bg-gray-300 text-gray-600 px-4 py-2 rounded-lg cursor-not-allowed">
                                Stok Habis
                            </button>
                        @endif
                    @else
                        <a href="{{ route('login') }}" 
                           class="block text-center bg-[#D2552D] text-white px-4 py-2 rounded-lg hover:bg-[#B34726]">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login untuk Memesan
                        </a>
                    @endauth
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-8">
                <p class="text-gray-500 text-lg">Tidak ada menu yang tersedia</p>
            </div>
        @endforelse
    </div>

    @if($kuliners->hasPages())
        <div class="mt-8">
            {{ $kuliners->links() }}
        </div>
    @endif
</div>
@endsection

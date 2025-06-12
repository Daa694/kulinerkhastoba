@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-[#2E5A43] mb-8 text-center">Menu Rekomendasi</h1>
    
    @if($recommendedProducts->isEmpty())
        <div class="text-center py-10">
            <p class="text-gray-600 mb-4">Belum ada menu yang direkomendasikan</p>
            <a href="{{ route('menu') }}" class="inline-block bg-[#2E5A43] text-white px-6 py-2 rounded-lg hover:bg-[#244934] transition-colors duration-300">
                <i class="fas fa-utensils mr-2"></i>Lihat Semua Menu
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($recommendedProducts as $product)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                @if($product->gambar)
                    <img src="{{ Storage::url($product->gambar) }}" 
                         alt="{{ $product->nama }}" 
                         class="w-full h-60 object-cover">
                @else
                    <div class="w-full h-60 bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-400">No image available</span>
                    </div>
                @endif

                <div class="p-6">
                    <h2 class="text-xl font-bold text-[#2E5A43] mb-2">{{ $product->nama }}</h2>
                    <p class="text-gray-600 mb-4 line-clamp-2">{{ $product->deskripsi }}</p>
                    
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <span class="text-yellow-400 mr-1">
                                <i class="fas fa-star"></i>
                            </span>
                            <span class="font-semibold">
                                {{ number_format($product->ratings_avg_rating ?? 0, 1) }}
                            </span>
                        </div>
                        <span class="text-xl font-bold text-[#D2552D]">
                            Rp {{ number_format($product->harga, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center">
                        @auth
                            @if($product->stok > 0)
                                <form action="{{ route('cart.add') }}" method="POST" class="flex-1 mr-2">
                                    @csrf
                                    <input type="hidden" name="kuliner_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" 
                                            class="w-full bg-[#2E5A43] text-white px-4 py-2 rounded hover:bg-[#244934] transition-colors">
                                        <i class="fas fa-cart-plus mr-2"></i>
                                        Tambah ke Keranjang
                                    </button>
                                </form>
                            @else
                                <button disabled class="w-full bg-gray-400 text-white px-4 py-2 rounded cursor-not-allowed">
                                    Stok Habis
                                </button>
                            @endif
                        @else
                            <a href="{{ route('login') }}" 
                               class="w-full bg-[#D8532B] text-white text-center px-4 py-2 rounded hover:bg-[#C14B27] transition-colors">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                Login untuk Beli
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        @if($recommendedProducts->hasPages())
            <div class="mt-8">
                {{ $recommendedProducts->links() }}
            </div>
        @endif
    @endif
</div>
@endsection

<meta name="csrf-token" content="{{ csrf_token() }}">
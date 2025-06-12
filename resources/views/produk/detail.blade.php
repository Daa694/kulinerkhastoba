@extends('layouts.app')

@section('content')
<div class="container py-10">
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="md:flex">
            @if($product->gambar_kuliner)
                <div class="md:flex-shrink-0">
                    <img src="{{ asset('images/' . $product->gambar_kuliner) }}" alt="{{ $product->nama }}" 
                         class="h-96 w-full object-cover md:w-96">
                </div>
            @endif
            
            <div class="p-8">
                <h1 class="text-3xl font-bold text-toba-green-dark mb-4">{{ $product->nama }}</h1>
                <p class="text-2xl font-semibold text-gray-700 mb-4">
                    Rp {{ number_format($product->harga, 0, ',', '.') }}
                </p>
                <div class="mb-4">
                    <span class="text-yellow-500 text-lg">
                        Rating: {{ number_format($product->ratings_avg_rating ?? 0, 1) }} ⭐
                    </span>
                </div>
                @if($product->deskripsi)
                    <div class="prose max-w-none mt-4">
                        <h3 class="text-xl font-semibold mb-2">Deskripsi</h3>
                        <p class="text-gray-600">{{ $product->deskripsi }}</p>
                    </div>
                @endif
                
                <div class="mt-8">                <form action="{{ route('cart.add') }}" method="POST" class="flex gap-4 items-end">
                    @csrf
                    <input type="hidden" name="id" value="{{ $product->id }}">
                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                        <input type="number" name="quantity" id="quantity" min="1" value="1"
                               class="border-gray-300 focus:border-[#D8532B] focus:ring-[#D8532B] rounded-md shadow-sm w-20">
                    </div>
                    <button type="submit"
                            class="bg-[#D8532B] text-white px-6 py-2 rounded-md hover:bg-[#C14B27] transition-colors">
                        Tambah ke Keranjang
                    </button>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

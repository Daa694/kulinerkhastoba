@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <h1 class="text-2xl font-bold mb-4 text-[#D8532B]">{{ $kuliner->nama }}</h1>

    <img src="{{ asset('images/' . $kuliner->gambar_kuliner) }}" 
         alt="{{ $kuliner->nama }}" 
         class="w-full h-64 object-cover rounded mb-4">

    <div class="bg-white p-6 rounded-lg shadow-md">
        <p class="mb-4"><strong class="text-[#D8532B]">Harga:</strong> Rp {{ number_format($kuliner->harga, 0, ',', '.') }}</p>
        
        @if($kuliner->history)
            <p class="mb-4"><strong class="text-[#D8532B]">Sejarah:</strong> {{ $kuliner->history }}</p>
        @endif
        
        @if($kuliner->resep)
            <p class="mb-4"><strong class="text-[#D8532B]">Resep:</strong> {{ $kuliner->resep }}</p>
        @endif
        
        @if($kuliner->cooking_steps)
            <p class="mb-4"><strong class="text-[#D8532B]">Langkah Masak:</strong> {{ $kuliner->cooking_steps }}</p>
        @endif
    </div>

    <div class="mt-6 flex gap-4">
        <a href="{{ route('menu') }}" class="bg-[#D8532B] text-white px-4 py-2 rounded hover:bg-[#c24623] transition">
            Kembali ke Menu
        </a>
        
        <form action="{{ route('produk.keranjang', $kuliner) }}" method="POST" class="inline">
            @csrf
            <div class="flex items-center gap-2">
                <label for="jumlah" class="text-sm font-medium">Jumlah:</label>
                <input type="number" name="jumlah" id="jumlah" value="1" min="1" max="10" 
                       class="w-16 px-2 py-1 border border-gray-300 rounded text-center">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                    Beli / Tambah ke Keranjang
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

<!-- @extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">{{ $kuliner->nama }}</h1>

    <img src="{{ asset('images/' . $kuliner->gambar_kuliner) }}" 
         alt="{{ $kuliner->nama }}" 
         class="w-full h-64 object-cover rounded mb-4">

    <p class="mb-2"><strong>Harga:</strong> Rp {{ number_format($kuliner->harga, 0, ',', '.') }}</p>
    <p class="mb-2"><strong>Sejarah:</strong> {{ $kuliner->history }}</p>
    <p class="mb-2"><strong>Resep:</strong> {{ $kuliner->resep }}</p>
    <p class="mb-4"><strong>Langkah Masak:</strong> {{ $kuliner->cooking_steps }}</p>

    <a href="{{ route('produk') }}" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition">
        Kembali ke Menu
    </a>
</div>
@endsection -->

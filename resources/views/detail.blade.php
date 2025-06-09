@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <!-- TROUBLESHOOTING STATUS LOGIN -->
    <div class="mb-2 p-2 bg-gray-100 rounded text-xs text-gray-500">
        Status Auth::check(): <b>{{ Auth::check() ? 'Sudah login' : 'Belum login' }}</b> <br>
        User: <b>{{ Auth::user() ? Auth::user()->name : '-' }}</b>
    </div>

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

    {{-- RATING SECTION --}}
    <div class="mt-6 mb-4 bg-gray-50 rounded p-4">
        <div class="flex items-center gap-2">
            <span class="font-semibold text-[#D8532B]">Rating: </span>
            <span class="text-gray-500">Belum ada rating</span>
        </div>

        @auth
        <form method="POST" action="{{ route('produk.rating', $kuliner->id) }}" class="mt-2 flex items-center gap-2">
            @csrf
            <label for="rating" class="text-sm">Beri rating:</label>
            <select name="rating" id="rating" class="border rounded px-2 py-1">
                @for($i=1; $i<=5; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
            <button type="submit" class="bg-[#D8532B] text-white px-4 py-1 rounded hover:bg-[#c24623] transition">
                Submit
            </button>
        </form>
        @else
        <div class="text-xs text-gray-400 mt-1">*Login untuk memberi rating</div>
        @endauth
    </div>
    {{-- END RATING SECTION --}}

    <div class="mt-6 flex gap-4">
        <a href="{{ route('menu') }}" class="bg-[#D8532B] text-white px-4 py-2 rounded hover:bg-[#c24623] transition">
            Kembali ke Menu
        </a>
        <form action="{{ route('produk.keranjang', $kuliner->id) }}" method="POST" class="inline">
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
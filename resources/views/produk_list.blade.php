@extends('layouts.app')

@section('content')
<div class="container py-10">
    <h1 class="text-4xl font-bold mb-10 text-center text-orange-600">Daftar Kuliner</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @forelse($kuliners as $kuliner)
        <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 flex flex-col">
            <img src="{{ asset('images/' . $kuliner->gambar_kuliner) }}" alt="{{ $kuliner->nama }}" class="w-full h-56 object-cover rounded-t-xl">
            <div class="p-6 flex flex-col flex-1">
                <h2 class="text-2xl font-semibold text-toba-green-dark mb-2">{{ $kuliner->nama }}</h2>
                <p class="text-gray-700 mb-2">Rp {{ number_format($kuliner->harga, 0, ',', '.') }}</p>
                {{-- Tampilkan rating jika ada --}}
                @if(isset($kuliner->rating))
                    <p class="mb-2">Rating: {{ $kuliner->rating }} / 5</p>
                @endif
                <div class="mt-auto flex flex-col gap-2">
                    <a href="#" class="border border-[#D8532B] text-[#D8532B] px-4 py-2 rounded text-center hover:bg-orange-100 transition">Detail</a>
                    <button class="bg-[#D8532B] text-white px-4 py-2 rounded hover:bg-[#c24623] transition">Beli</button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-10">
            <p class="text-gray-500 text-lg">Belum ada data kuliner tersedia.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
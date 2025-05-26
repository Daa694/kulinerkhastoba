@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="bg-[#F7F1E5] py-12 text-center">
        <h1 class="text-3xl font-bold text-[#D8532B]">Menu TOBA TASTE</h1>
        <p class="text-[#D8532B] mt-2">Nikmati cita rasa khas Batak dalam setiap gigitan.</p>
    </section>

    <!-- Menu Dinamis dari Database -->
    <section class="py-12 px-6 bg-[#F7F1E5]">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
            @forelse($kuliners as $kuliner)
                <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                    <img src="{{ asset('images/' . $kuliner->gambar_kuliner) }}" alt="{{ $kuliner->nama }}" class="w-full h-40 object-cover rounded-t-lg">
                    <div class="p-2 text-center">
                        <p class="text-[#D8532B] font-bold">{{ $kuliner->nama }}</p>
                        <p class="text-gray-700">Rp {{ number_format($kuliner->harga, 0, ',', '.') }}</p>
                        <div class="mt-2 flex justify-center gap-2">
                            <button class="bg-[#D8532B] text-white px-3 py-1 rounded text-sm hover:bg-[#c24623]">Beli</button>
                            <a href="{{ route('produk.detail', $kuliner->id) }}" class="border border-[#D8532B] text-[#D8532B] px-3 py-1 rounded text-sm hover:bg-orange-100 inline-block">Detail</a>
                        </div>

                        @if(auth()->check() && auth()->user()->role === 'admin')
                            <div class="mt-2 flex justify-center gap-2">
                                <a href="{{ route('kuliner.edit', $kuliner->id) }}" class="text-blue-500">Edit</a>
                                <form action="{{ route('kuliner.destroy', $kuliner->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500">Hapus</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center text-gray-500">Belum ada data kuliner.</div>
            @endforelse
        </div>
    </section>
@endsection

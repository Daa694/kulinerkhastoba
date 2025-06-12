@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-[#2E5A43]">Daftar Produk</h1>
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('produk.create') }}" 
               class="bg-[#2E5A43] text-white px-4 py-2 rounded-lg hover:bg-[#244934]">
                Tambah Produk
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($produks as $produk)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                @if($produk->gambar)
                    <img src="{{ asset('images/' . $produk->gambar) }}" 
                         alt="{{ $produk->nama }}" 
                         class="w-full h-48 object-cover">
                @endif
                
                <div class="p-4">
                    <h2 class="text-xl font-semibold text-[#2E5A43] mb-2">{{ $produk->nama }}</h2>
                    <p class="text-gray-600 mb-2">{{ $produk->detail }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-[#D2552D]">
                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                        </span>
                        
                        @if(auth()->user()->role === 'admin')
                            <div class="flex space-x-2">
                                <a href="{{ route('produk.edit', $produk->id) }}" 
                                   class="text-blue-500 hover:text-blue-700">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('produk.destroy', $produk->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

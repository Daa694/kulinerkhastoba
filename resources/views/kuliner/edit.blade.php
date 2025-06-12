@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-6 text-[#2E5A43]">Edit Kuliner</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.kuliner.update', $kuliner->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="nama">
                Nama Kuliner
            </label>
            <input type="text" name="nama" id="nama" value="{{ $kuliner->nama }}" 
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="harga">
                Harga
            </label>
            <input type="number" name="harga" id="harga" value="{{ $kuliner->harga }}"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
        </div>        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="deskripsi">
                Deskripsi
            </label>
            <textarea name="deskripsi" id="deskripsi" rows="4" 
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">{{ $kuliner->deskripsi }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="stok">
                Stok
            </label>
            <input type="number" name="stok" id="stok" value="{{ $kuliner->stok }}"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"
                   min="0">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="tersedia">
                Tersedia
            </label>
            <select name="tersedia" id="tersedia" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                <option value="1" {{ $kuliner->tersedia ? 'selected' : '' }}>Ya</option>
                <option value="0" {{ !$kuliner->tersedia ? 'selected' : '' }}>Tidak</option>
            </select>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="gambar">
                Gambar
            </label>
            @if($kuliner->gambar)
                <div class="mb-2">
                    <img src="{{ Storage::url($kuliner->gambar) }}" 
                         alt="{{ $kuliner->nama }}" 
                         class="w-32 h-32 object-cover rounded">
                </div>
            @endif
            <input type="file" 
                   name="gambar" 
                   id="gambar"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"
                   accept="image/jpeg,image/png,image/jpg">
            <p class="text-sm text-gray-600 mt-1">Biarkan kosong jika tidak ingin mengubah gambar</p>
        </div>

        <div class="flex items-center justify-between mt-6">
            <a href="{{ route('admin.kuliner.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
            <button type="submit" 
                    class="bg-[#2E5A43] hover:bg-[#244934] text-white font-bold py-2 px-4 rounded">
                Update Kuliner
            </button>
        </div>
    </form>
    </div>
</div>
@endsection

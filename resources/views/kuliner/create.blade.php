@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-[#2E5A43]">Tambah Kuliner Baru</h1>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.kuliner.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="nama" class="block text-gray-700 text-sm font-bold mb-2">Nama Kuliner</label>
                    <input type="text" 
                           name="nama" 
                           id="nama"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                           required 
                           value="{{ old('nama') }}"
                           placeholder="Masukkan nama kuliner">
                </div>

                <div>
                    <label for="deskripsi" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
                    <textarea name="deskripsi" 
                              id="deskripsi"
                              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                              required 
                              rows="4"
                              placeholder="Masukkan deskripsi kuliner">{{ old('deskripsi') }}</textarea>
                </div>

                <div>
                    <label for="harga" class="block text-gray-700 text-sm font-bold mb-2">Harga</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-600">Rp</span>
                        <input type="number" 
                               name="harga" 
                               id="harga"
                               class="shadow appearance-none border rounded w-full py-2 pl-10 pr-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                               required 
                               value="{{ old('harga') }}"
                               min="0"
                               step="1000"
                               placeholder="0">
                    </div>
                </div>

                <div>
                    <label for="gambar" class="block text-gray-700 text-sm font-bold mb-2">Gambar</label>
                    <input type="file" 
                           name="gambar" 
                           id="gambar"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                           accept="image/jpeg,image/png,image/jpg" 
                           required>
                </div>
                
                <div class="flex justify-between items-center pt-4">
                    <a href="{{ route('admin.kuliner.index') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Kembali
                    </a>
                    <button type="submit" 
                            class="bg-[#2E5A43] hover:bg-[#244934] text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Simpan Kuliner
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

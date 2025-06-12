@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold text-[#2E5A43] mb-6">Edit Menu: {{ $kuliner->nama }}</h1>

            <form action="{{ route('admin.kuliner.update', $kuliner) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Menu</label>
                        <input type="text" name="nama" value="{{ old('nama', $kuliner->nama) }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2E5A43] focus:ring focus:ring-[#2E5A43] focus:ring-opacity-50">
                        @error('nama')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Harga</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">Rp</span>
                            </div>
                            <input type="number" name="harga" value="{{ old('harga', $kuliner->harga) }}" required min="0"
                                   class="pl-12 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2E5A43] focus:ring focus:ring-[#2E5A43] focus:ring-opacity-50">
                        </div>
                        @error('harga')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" required
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2E5A43] focus:ring focus:ring-[#2E5A43] focus:ring-opacity-50">{{ old('deskripsi', $kuliner->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Stok</label>
                        <input type="number" name="stok" value="{{ old('stok', $kuliner->stok) }}" required min="0"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2E5A43] focus:ring focus:ring-[#2E5A43] focus:ring-opacity-50">
                        @error('stok')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Gambar Saat Ini</label>
                        @if($kuliner->gambar)
                            <div class="mt-2">
                                <img src="{{ Storage::url($kuliner->gambar) }}" 
                                     alt="{{ $kuliner->nama }}" 
                                     class="w-32 h-32 object-cover rounded">
                            </div>
                        @endif
                        <div class="mt-2">
                            <label class="block text-sm font-medium text-gray-700">Ganti Gambar (opsional)</label>
                            <input type="file" name="gambar" accept="image/*"
                                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#2E5A43] file:text-white hover:file:bg-[#244934]">
                        </div>
                        @error('gambar')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="tersedia" id="tersedia" value="1" 
                               {{ old('tersedia', $kuliner->tersedia) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-[#2E5A43] focus:border-[#2E5A43] focus:ring focus:ring-[#2E5A43] focus:ring-opacity-50">
                        <label for="tersedia" class="ml-2 block text-sm text-gray-700">Menu Tersedia</label>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end space-x-3">
                    <a href="{{ route('admin.kuliner.index') }}" 
                       class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition duration-200">
                        Batal
                    </a>
                    <button type="submit" 
                            class="bg-[#2E5A43] text-white px-4 py-2 rounded hover:bg-[#244934] transition duration-200">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

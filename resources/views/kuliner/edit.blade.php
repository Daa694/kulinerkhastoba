@extends('layouts.app')

@section('content')
<div class="container py-10 max-w-lg mx-auto">
    <h1 class="text-2xl font-bold mb-6 text-center text-orange-600">Edit Kuliner</h1>
    <form action="{{ route('kuliner.update', $kuliner->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="nama" class="block mb-2">Nama Kuliner</label>
            <input type="text" name="nama" id="nama" class="w-full p-2 border rounded" value="{{ old('nama', $kuliner->nama) }}" required>
        </div>
        <div class="mb-4">
            <label for="harga" class="block mb-2">Harga</label>
            <input type="number" name="harga" id="harga" class="w-full p-2 border rounded" value="{{ old('harga', $kuliner->harga) }}" required>
        </div>
        <div class="mb-4">
            <label for="gambar_kuliner" class="block mb-2">Gambar (nama file di public/images)</label>
            <input type="text" name="gambar_kuliner" id="gambar_kuliner" class="w-full p-2 border rounded" value="{{ old('gambar_kuliner', $kuliner->gambar_kuliner) }}">
        </div>
        <div class="mb-4">
            <label for="detail" class="block mb-2">Detail Kuliner</label>
            <textarea name="detail" id="detail" class="w-full p-2 border rounded" required>{{ old('detail', $kuliner->detail) }}</textarea>
        </div>
        <button type="submit" class="w-full bg-orange-600 text-white py-2 rounded hover:bg-orange-700">Simpan Perubahan</button>
    </form>
</div>
@endsection

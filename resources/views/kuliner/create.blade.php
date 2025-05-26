@extends('layouts.app')

@section('content')
<div class="container py-10 max-w-lg mx-auto">
    <h1 class="text-2xl font-bold mb-6 text-center text-orange-600">Tambah Kuliner</h1>
    <form action="{{ route('kuliner.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Nama Kuliner</label>
            <input type="text" name="nama" class="w-full border border-gray-300 p-2 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Harga</label>
            <input type="number" name="harga" class="w-full border border-gray-300 p-2 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Gambar (nama file di public/images)</label>
            <input type="text" name="gambar_kuliner" class="w-full border border-gray-300 p-2 rounded">
        </div>
        <div class="mb-4">
            <label for="detail" class="block mb-2">Detail Kuliner</label>
            <textarea name="detail" id="detail" class="w-full p-2 border rounded" required>{{ old('detail') }}</textarea>
        </div>
        <button type="submit" class="w-full bg-orange-600 text-white py-2 rounded hover:bg-orange-700">Simpan</button>
    </form>
</div>
@endsection

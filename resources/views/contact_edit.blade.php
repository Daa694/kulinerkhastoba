@extends('layouts.app')

@section('title', 'Edit Kontak - TOBA TASTE')

@section('content')
<div class="container mx-auto max-w-lg py-10">
    <h2 class="text-2xl font-bold mb-6 text-[#2E5A43] text-center">Edit Kontak Website</h2>
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif
    <form method="POST" action="{{ route('contact.update') }}" class="space-y-4 bg-white p-6 rounded shadow">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-gray-700 mb-1">Alamat</label>
            <input type="text" name="alamat" value="{{ old('alamat', $contact->alamat ?? '') }}" class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-gray-700 mb-1">Telepon</label>
            <input type="text" name="telepon" value="{{ old('telepon', $contact->telepon ?? '') }}" class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $contact->email ?? '') }}" class="w-full border rounded px-3 py-2">
        </div>
        <button type="submit" class="w-full bg-[#2E5A43] text-white py-2 px-4 rounded hover:bg-[#244934]">Simpan Perubahan</button>
    </form>
    <div class="mt-6 text-center">
        <a href="{{ route('contact') }}" class="text-[#D2552D] hover:underline">Kembali ke Halaman Kontak</a>
    </div>
</div>
@endsection

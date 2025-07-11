@extends('layouts.app')

@section('title', 'Edit Tentang Kami - TOBA TASTE')

@section('content')
<div class="container mx-auto max-w-2xl py-12">
    <h1 class="text-3xl font-bold text-[#D2552D] mb-6">Edit Tentang Kami</h1>
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-md">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif
    @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-md">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('about.update') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-6">
            <label for="about_content" class="block text-lg font-semibold mb-2">Isi Tentang Kami</label>
            <textarea name="about_content" id="about_content" rows="10" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-[#D2552D]/50">{{ old('about_content', $aboutContent ?? '') }}</textarea>
        </div>
        <button type="submit" class="bg-[#D2552D] text-white px-6 py-2 rounded hover:bg-[#b9431c] font-semibold">Simpan Perubahan</button>
        <a href="{{ route('contact') }}" class="ml-4 text-gray-600 hover:underline">Batal</a>
    </form>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-[#2E5A43]">Daftar Akun</h2>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            
            <div>
                <label for="name" class="block text-gray-700 mb-2">Nama</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror" required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-gray-700 mb-2">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                    class="w-full border rounded px-3 py-2 @error('email') border-red-500 @enderror" required>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="alamat_pengiriman" class="block text-gray-700 mb-2">Alamat Pengiriman</label>
                <textarea name="alamat_pengiriman" id="alamat_pengiriman" rows="3" 
                    class="w-full border rounded px-3 py-2 @error('alamat_pengiriman') border-red-500 @enderror" required>{{ old('alamat_pengiriman') }}</textarea>
                @error('alamat_pengiriman')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-gray-700 mb-2">Password</label>
                <input type="password" name="password" id="password"
                    class="w-full border rounded px-3 py-2 @error('password') border-red-500 @enderror" required>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-gray-700 mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <button type="submit" class="w-full bg-[#2E5A43] text-white py-2 px-4 rounded hover:bg-[#244934]">
                Daftar
            </button>
        </form>

        <p class="text-center mt-4 text-gray-600">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="text-[#2E5A43] hover:underline">Login</a>
        </p>
    </div>
</div>
@endsection

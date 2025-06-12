@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-[#F6F0E7]">
    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <div class="text-center mb-8">
            <img src="{{ asset('images/tobataste.png') }}" alt="Logo" class="mx-auto h-20 w-20 mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Login</h2>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-center">
                {{ $errors->first() }}
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-center">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block mb-1 font-semibold text-gray-700">Email</label>
                <input type="email" name="email" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-green-400" value="{{ old('email') }}" required>
            </div>

            <div>
                <label class="block mb-1 font-semibold text-gray-700">Password</label>
                <input type="password" name="password" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-green-400" required>
            </div>

            <button type="submit" class="w-full bg-[#2E5A43] text-white py-2 rounded hover:bg-[#244934] transition duration-200">
                Login
            </button>
        </form>

        <div class="mt-4 text-center space-y-2">
            <p class="text-sm text-gray-600">
                Belum punya akun?
                <a href="{{ route('register.form') }}" class="text-[#2E5A43] hover:underline">Daftar Sekarang</a>
            </p>
            <p class="text-sm text-gray-600">
                <a href="{{ route('admin.login') }}" class="text-[#2E5A43] hover:underline">Login sebagai Admin</a>
            </p>
        </div>
    </div>
</div>
@endsection

@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <!-- Selamat Datang Section -->
    <div class="text-center mb-8">
        <h1 class="text-3xl font-extrabold text-gray-800">Selamat Datang di Website Kami</h1>
        <p class="mt-2 text-gray-600">Jelajahi rasa autentik khas Toba bersama kami.</p>
    </div>

    <!-- Form Login Section -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-center text-green-700">Login</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-center">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-center">
                {{ $errors->first() }}
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

            <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition duration-200">
                Login
            </button>
        </form>

        <p class="mt-4 text-center text-sm text-gray-600">
            Belum punya akun?
            <a href="{{ route('register.form') }}" class="text-green-600 hover:underline">Daftar Sekarang</a>
        </p>
    </div>
@endsection

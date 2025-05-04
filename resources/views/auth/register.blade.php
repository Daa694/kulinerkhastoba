@extends('layouts.auth')

@section('title', 'Register')

@section('content')
    <!-- Selamat Datang Section -->
    <div class="text-center mb-8">
        <h1 class="text-3xl font-extrabold text-gray-800">Buat Akun Baru</h1>
        <p class="mt-2 text-gray-600">Gabung dan nikmati berbagai kuliner khas Toba!</p>
    </div>

    <!-- Form Register Section -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-center text-green-700">Register</h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block mb-1 font-semibold text-gray-700">Nama</label>
                <input type="text" name="nama" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-green-400" value="{{ old('nama') }}" required>
            </div>

            <div>
                <label class="block mb-1 font-semibold text-gray-700">Email</label>
                <input type="email" name="email" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-green-400" value="{{ old('email') }}" required>
            </div>

            <div>
                <label class="block mb-1 font-semibold text-gray-700">Password</label>
                <input type="password" name="password" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-green-400" required>
            </div>

            <div>
                <label class="block mb-1 font-semibold text-gray-700">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-green-400" required>
            </div>

            <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition duration-200">
                Register
            </button>
        </form>

        <p class="mt-4 text-center text-sm text-gray-600">
            Sudah punya akun?
            <a href="{{ route('login.form') }}" class="text-green-600 hover:underline">Login Sekarang</a>
        </p>
    </div>
@endsection

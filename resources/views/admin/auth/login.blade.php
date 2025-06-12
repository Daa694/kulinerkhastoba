@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <div class="text-center mb-8">
            <img src="{{ asset('images/tobataste.png') }}" alt="Logo" class="mx-auto h-20 w-20 mb-4">
            <h2 class="text-2xl font-bold text-[#2E5A43]">Admin Login</h2>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-gray-700 text-sm font-semibold mb-2">Email</label>
                <input type="email" name="email" required 
                       class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#2E5A43]">
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-semibold mb-2">Password</label>
                <input type="password" name="password" required 
                       class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#2E5A43]">
            </div>            <button type="submit" 
                class="w-full bg-[#2E5A43] text-white py-2 rounded hover:bg-[#244934] transition duration-200">
                Login as Admin
            </button>
        </form>

        <div class="mt-4 text-center">            <a href="{{ route('login') }}" class="text-sm text-[#2E5A43] hover:underline">
                Back to User Login
            </a>
        </div>
    </div>
</div>
@endsection
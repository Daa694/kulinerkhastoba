@extends('layouts.app')

@section('content')
    <div class="container py-10 max-w-lg mx-auto">
        <h1 class="text-2xl font-bold mb-6 text-center text-[#D2552D]">Profil Pengguna</h1>

        <div class="bg-white rounded-lg shadow p-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Data Pengguna -->
            <p class="mb-2"><strong>Nama:</strong> {{ $user->name }}</p>
            <p class="mb-2"><strong>Email:</strong> {{ $user->email }}</p>
            <p class="mb-2"><strong>Role:</strong> {{ $user->role }}</p>
            <p class="mb-4"><strong>Alamat Pengiriman:</strong> {{ $user->alamat_pengiriman ?? 'Belum ada alamat' }}</p>

            <!-- Form Ubah Alamat -->
            <form action="{{ route('profil.updateAlamat') }}" method="POST" class="mb-4">
                @csrf
                <label class="block mb-1 font-semibold">Edit Alamat Pengiriman</label>
                <input type="text" name="alamat_pengiriman" value="{{ old('alamat_pengiriman', $user->alamat_pengiriman) }}"
                    class="w-full border rounded px-3 py-2 mb-2 @error('alamat_pengiriman') border-red-500 @enderror"
                    required>
                <button type="submit"
                    class="bg-[#D2552D] text-white px-4 py-2 rounded hover:bg-[#b8441f] shadow-md hover:shadow-lg transition-all duration-300">
                    <i class="fas fa-save mr-1 animate-pulse"></i> Simpan Alamat
                </button>
            </form>

            <!-- Tombol Kembali -->
            <div class="mt-6 flex justify-start">
                <a href="{{ route('menu') }}"
                    class="inline-flex items-center px-5 py-2 bg-[#D2552D] text-white rounded-md font-medium shadow-md hover:bg-[#b8441f] hover:shadow-xl hover:scale-105 transition transform duration-300">
                    <i class="fas fa-arrow-left mr-2 animate-pulse"></i> Kembali ke Menu
                </a>
            </div>
        </div>

        <!-- Tombol Logout di Paling Bawah -->
        <form action="{{ route('logout') }}" method="POST" class="mt-6">
            @csrf
            <button type="submit"
                class="w-full inline-flex justify-center items-center px-5 py-3 bg-red-600 text-white font-semibold rounded-md shadow-md hover:bg-red-700 hover:shadow-xl hover:scale-105 transform transition duration-300">
                <i class="fas fa-sign-out-alt mr-2 animate-pulse"></i> Logout
            </button>
        </form>
    </div>
@endsection

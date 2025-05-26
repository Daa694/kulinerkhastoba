@extends('layouts.app')

@section('content')
<div class="container py-10 max-w-lg mx-auto">
    <h1 class="text-2xl font-bold mb-6 text-center text-orange-600">Profil Pengguna</h1>
    <div class="bg-white rounded-lg shadow p-6">
        <p class="mb-2"><strong>Nama:</strong> {{ session('user_nama') }}</p>
        <p class="mb-2"><strong>Email:</strong> {{ session('user_email') }}</p>
        <p class="mb-2"><strong>Role:</strong> {{ session('user_role') }}</p>
        <form action="{{ route('profil.updateAlamat') }}" method="POST" class="mb-4">
            @csrf
            <label class="block mb-1 font-semibold">Alamat Pengiriman</label>
            <input type="text" name="alamat_pengiriman" value="{{ old('alamat_pengiriman', $alamat ?? '') }}" class="w-full border rounded px-3 py-2 mb-2" required>
            <button type="submit" class="bg-orange-600 text-white px-4 py-2 rounded">Simpan Alamat</button>
        </form>
        <h2 class="text-lg font-bold mt-6 mb-2">Riwayat Pesanan</h2>
        <ul class="list-disc pl-5">
            @forelse($pesanan as $order)
                <li>{{ $order->nama_produk }} - {{ $order->jumlah }}x (Rp {{ number_format($order->total_harga,0,',','.') }})</li>
            @empty
                <li>Belum ada pesanan.</li>
            @endforelse
        </ul>
        <form action="{{ route('logout') }}" method="POST" class="mt-6">
            @csrf
            <button type="submit" class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-700">Logout</button>
        </form>
    </div>
</div>
@endsection

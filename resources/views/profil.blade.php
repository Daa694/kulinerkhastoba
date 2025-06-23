@extends('layouts.app')

@section('content')
<div class="container py-10 max-w-lg mx-auto">
    <h1 class="text-2xl font-bold mb-6 text-center text-orange-600">Profil Pengguna</h1>

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

        <p class="mb-2"><strong>Nama:</strong> {{ $user->name }}</p>
        <p class="mb-2"><strong>Email:</strong> {{ $user->email }}</p>
        <p class="mb-2"><strong>Role:</strong> {{ $user->role }}</p>

        <form action="{{ route('profil.updateAlamat') }}" method="POST" class="mb-4">
            @csrf
            <label class="block mb-1 font-semibold">Alamat Pengiriman</label>
            <input type="text" 
                   name="alamat_pengiriman" 
                   value="{{ old('alamat_pengiriman', $alamat) }}" 
                   class="w-full border rounded px-3 py-2 mb-2 @error('alamat_pengiriman') border-red-500 @enderror" 
                   required>
            <button type="submit" class="bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700 transition-colors">
                Simpan Alamat
            </button>
        </form>

        <h2 class="text-lg font-bold mt-6 mb-2">Riwayat Pesanan</h2>
        <div class="space-y-4">
            @forelse($pesanan as $order)
                <div class="border rounded p-4">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <p class="font-semibold">Order #{{ $order->order_id }}</p>
                            <p class="text-sm text-gray-600">{{ $order->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <span class="px-2 py-1 text-sm rounded {{ $order->payment_status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                    <div class="space-y-2">
                        @foreach($order->orderItems as $item)
                            <div class="flex justify-between items-center text-sm">
                                <span>{{ $item->kuliner->nama }} x {{ $item->quantity }}</span>
                                <span>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-2 pt-2 border-t flex justify-between font-semibold">
                        <span>Total</span>
                        <span>Rp {{ number_format($order->gross_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">Belum ada pesanan.</p>
            @endforelse
        </div>

        <form action="{{ route('logout') }}" method="POST" class="mt-6">
            @csrf
            <button type="submit" class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-700 transition-colors">
                Logout
            </button>
        </form>
    </div>
</div>
@endsection
  
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-[#2E5A43]">
                    Detail Pesanan #{{ $order->id }}
                </h1>
                <span class="px-4 py-2 rounded-full text-sm
                    @if($order->status === 'completed') bg-green-100 text-green-800
                    @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                    @else bg-yellow-100 text-yellow-800
                    @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </div>

            <div class="border-t border-gray-200 pt-6">
                <div class="mb-6">
                    <h2 class="text-lg font-semibold mb-2">Informasi Pelanggan</h2>
                    <p class="text-gray-600">{{ $order->user->name }}</p>
                    <p class="text-gray-600">{{ $order->user->email }}</p>
                    <p class="text-gray-600">{{ $order->user->alamat_pengiriman }}</p>
                </div>

                <div class="mb-6">
                    <h2 class="text-lg font-semibold mb-2">Item Pesanan</h2>
                    <div class="divide-y divide-gray-200">
                        @foreach($order->orderItems as $item)
                            <div class="py-4 flex justify-between">
                                <div>
                                    <p class="font-medium">{{ $item->kuliner->nama }}</p>
                                    <p class="text-sm text-gray-600">
                                        {{ $item->quantity }}x @ Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </p>
                                </div>
                                <p class="font-medium">
                                    Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-semibold">Total</span>
                        <span class="text-2xl font-bold">
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                @if($order->canBeCancelled())
                    <div class="mt-6 text-right">
                        <form action="{{ route('orders.cancel', $order) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" 
                                    class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
                                    onclick="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                Batalkan Pesanan
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

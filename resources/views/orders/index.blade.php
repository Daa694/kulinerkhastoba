@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold text-[#2E5A43] mb-6">Riwayat Pesanan</h2>

    @if($orders->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <p class="text-gray-500">Belum ada pesanan</p>
            <a href="{{ route('menu') }}" class="inline-block mt-4 bg-[#2E5A43] text-white px-6 py-2 rounded hover:bg-[#244934]">
                Mulai Belanja
            </a>
        </div>
    @else
        <div class="grid gap-6">
            @foreach($orders as $order)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-semibold">Order #{{ $order->order_id }}</h3>
                            <p class="text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[#D2552D] font-bold">Rp {{ number_format($order->gross_amount, 0, ',', '.') }}</p>
                            <span class="inline-block px-3 py-1 rounded text-sm 
                                @if($order->payment_status == 'settlement' || $order->payment_status == 'capture') bg-green-100 text-green-800
                                @elseif($order->payment_status == 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

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
            @foreach($orders as $order)                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-semibold">Order #{{ $order->order_id }}</h3>
                            <p class="text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</p>
                            
                            <!-- Order Status -->
                            <div class="mt-2">
                                <span class="inline-block px-3 py-1 rounded text-sm mr-2
                                    @if($order->status === 'sukses') bg-green-100 text-green-800
                                    @elseif($order->status === 'diantar') bg-blue-100 text-blue-800
                                    @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    Status: {{ ucfirst($order->status) }}
                                </span>

                                <span class="inline-block px-3 py-1 rounded text-sm 
                                    @if($order->payment_status == 'settlement' || $order->payment_status == 'capture') bg-green-100 text-green-800
                                    @elseif($order->payment_status == 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    Pembayaran: {{ ucfirst($order->payment_status) }}
                                </span>
                            </div>
                            
                            <!-- Confirmation Message and Button -->
                            @if($order->status === 'diantar')
                                <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                    <p class="text-sm text-yellow-700 mb-3">
                                        Pesanan Anda sedang dalam pengiriman. Jika Anda sudah menerima pesanan, silakan klik tombol di bawah ini:
                                    </p>
                                    <form action="{{ route('orders.confirm', $order) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                                class="w-full bg-[#2E5A43] text-white px-6 py-3 rounded-lg hover:bg-[#234434] transition-colors duration-300 flex items-center justify-center"
                                                onclick="return confirm('Apakah Anda yakin telah menerima pesanan ini?')">
                                            <i class="fas fa-check-circle mr-2"></i>
                                            Pesanan Sudah Diterima
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        <div class="text-right">
                            <p class="text-[#D2552D] font-bold">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                            @if($order->payment_status == 'settlement' || $order->payment_status == 'capture')
                                <a href="{{ route('orders.receipt', ['orderId' => $order->order_id]) }}" target="_blank"
                                   class="mt-2 inline-block bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors duration-300">
                                    <i class="fas fa-receipt mr-2"></i>Lihat Struk
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="mt-4 border-t pt-4">
                        <h4 class="font-semibold mb-2">Item Pesanan:</h4>
                        <div class="space-y-2">
                            @foreach($order->orderItems as $item)
                                <div class="flex justify-between items-center">
                                    <div>
                                        <span class="font-medium">{{ $item->kuliner->nama }}</span>
                                        <span class="text-gray-500 text-sm">({{ $item->quantity }}x)</span>
                                    </div>
                                    <span>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
    @if(session('success'))
        <div id="notifOrderSuccessModal" class="fixed inset-0 flex items-center justify-center z-50">
            <div class="bg-gradient-to-r from-[#2E5A43] to-[#1f3d2d] rounded-xl shadow-2xl p-8 w-80 animate-fade-in">
                <div class="flex flex-col items-center">
                    <i class="fas fa-check-circle text-4xl text-yellow-300 mb-4"></i>
                    <span class="text-white text-lg font-semibold mb-2">Berhasil!</span>
                    <p class="text-white text-center mb-6">{{ session('success') }}</p>
                    <button onclick="closeOrderSuccessNotif()" class="px-6 py-2 rounded-full bg-yellow-400 text-[#2E5A43] font-bold shadow hover:bg-yellow-300 transition">OK</button>
                </div>
            </div>
            <div class="fixed inset-0 bg-black opacity-40" onclick="closeOrderSuccessNotif()"></div>
        </div>
        <style>
            @keyframes fade-in {
                from { opacity: 0; transform: scale(0.95); }
                to { opacity: 1; transform: scale(1); }
            }
            .animate-fade-in { animation: fade-in 0.2s ease; }
        </style>
        <script>
            function closeOrderSuccessNotif() {
                document.getElementById('notifOrderSuccessModal').classList.add('hidden');
            }
        </script>
    @endif
    @if(session('error'))
        <div id="notifOrderErrorModal" class="fixed inset-0 flex items-center justify-center z-50">
            <div class="bg-gradient-to-r from-[#2E5A43] to-[#1f3d2d] rounded-xl shadow-2xl p-8 w-80 animate-fade-in">
                <div class="flex flex-col items-center">
                    <i class="fas fa-exclamation-circle text-4xl text-yellow-300 mb-4"></i>
                    <span class="text-white text-lg font-semibold mb-2">Gagal!</span>
                    <p class="text-white text-center mb-6">{{ session('error') }}</p>
                    <button onclick="closeOrderErrorNotif()" class="px-6 py-2 rounded-full bg-yellow-400 text-[#2E5A43] font-bold shadow hover:bg-yellow-300 transition">OK</button>
                </div>
            </div>
            <div class="fixed inset-0 bg-black opacity-40" onclick="closeOrderErrorNotif()"></div>
        </div>
        <style>
            @keyframes fade-in {
                from { opacity: 0; transform: scale(0.95); }
                to { opacity: 1; transform: scale(1); }
            }
            .animate-fade-in { animation: fade-in 0.2s ease; }
        </style>
        <script>
            function closeOrderErrorNotif() {
                document.getElementById('notifOrderErrorModal').classList.add('hidden');
            }
        </script>
    @endif
@endsection

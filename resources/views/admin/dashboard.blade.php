@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h1 class="text-2xl font-bold text-[#2E5A43] mb-4">Dashboard Admin</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Statistics Cards -->
            <div class="bg-[#2E5A43] text-white p-6 rounded-lg">
                <h3 class="text-xl font-semibold mb-2">Total Menu</h3>
                <p class="text-sm opacity-90">{{ $totalKuliners ?? 0 }} Menu</p>
            </div>
            
            <div class="bg-[#2E5A43] text-white p-6 rounded-lg">
                <h3 class="text-xl font-semibold mb-2">Total Pesanan</h3>
                <p class="text-sm opacity-90">{{ $totalOrders ?? 0 }} Pesanan</p>
            </div>

            <div class="bg-[#2E5A43] text-white p-6 rounded-lg">
                <h3 class="text-xl font-semibold mb-2">Total Pengguna</h3>
                <p class="text-sm opacity-90">{{ $totalUsers ?? 0 }} Pengguna</p>
            </div>
        </div>
    </div>

    <!-- Recent Orders Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold text-[#2E5A43] mb-4">Pesanan Terbaru</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status Pembayaran</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status Pesanan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentOrders ?? [] as $order)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $order->order_id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $order->user?->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($order->total, 0, ',', '.') }}</td>                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->getPaymentStatusColorClass() }}">
                                    {{ $order->getPaymentStatusText() }}
                                </span>
                                @if($order->payment_type)
                                    <span class="ml-1 text-xs text-gray-500">({{ strtoupper($order->payment_type) }})</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($order->isPaymentSuccess())
                                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="inline-flex">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" 
                                            onchange="this.form.submit()"
                                            class="text-sm rounded-md border-gray-300 shadow-sm focus:border-[#2E5A43] focus:ring focus:ring-[#2E5A43] focus:ring-opacity-50
                                            {{ $order->status === 'pending' ? 'text-yellow-600' : 
                                               ($order->status === 'diantar' ? 'text-blue-600' : 
                                               ($order->status === 'sukses' ? 'text-green-600' : 'text-red-600')) }}">
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="diantar" {{ $order->status === 'diantar' ? 'selected' : '' }}>Sedang Diantar</option>
                                        <option value="sukses" {{ $order->status === 'sukses' ? 'selected' : '' }}>Selesai</option>
                                        <option value="batal" {{ $order->status === 'batal' ? 'selected' : '' }}>Batal</option>
                                    </select>
                                </form>
                                @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Menunggu Pembayaran
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.orders.show', $order) }}" 
                                   class="text-[#2E5A43] hover:text-[#234434]">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada pesanan terbaru
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Popular Menu Section -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-[#2E5A43] mb-4">Menu Populer</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($popularKuliners ?? [] as $kuliner)
                <div class="border rounded-lg p-4">
                    <h3 class="font-medium text-gray-900">{{ $kuliner->nama }}</h3>
                    <div class="flex items-center mt-2">
                        <span class="text-yellow-400 mr-1">⭐</span>
                        <span class="text-sm text-gray-600">
                            {{ number_format($kuliner->ratings_avg_rating, 1) }} 
                            ({{ $kuliner->ratings_count }} ulasan)
                        </span>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-500">
                    Belum ada menu yang dirating
                </div>
            @endforelse
        </div>
    </div>

    <!-- Monthly Sales Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold text-[#2E5A43] mb-4">Total Penghasilan</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Penjualan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah Pesanan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rata-rata per Pesanan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($monthlySales ?? [] as $month)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $month['period'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($month['total_sales'], 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ number_format($month['total_orders'], 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($month['average_order'], 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada data penjualan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

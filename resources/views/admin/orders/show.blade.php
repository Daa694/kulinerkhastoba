@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Detail Pesanan</h1>
            <a href="{{ route('admin.orders.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                Kembali
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="border rounded-lg p-4">
                <h2 class="text-lg font-semibold mb-4">Informasi Pesanan</h2>
                <div class="space-y-2">
                    <p><span class="font-medium">Order ID:</span> {{ $order->order_id }}</p>
                    <p><span class="font-medium">Tanggal:</span> {{ $order->created_at->format('d M Y H:i') }}</p>
                    <p><span class="font-medium">Status Pesanan:</span> 
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            {{ $order->status === 'sukses' ? 'bg-green-100 text-green-800' : 
                               ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                               ($order->status === 'diantar' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>
                    <p><span class="font-medium">Status Pembayaran:</span>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            {{ $order->payment_status === 'sukses' ? 'bg-green-100 text-green-800' : 
                               ($order->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </p>
                </div>
            </div>

            <div class="border rounded-lg p-4">
                <h2 class="text-lg font-semibold mb-4">Informasi Pelanggan</h2>
                <div class="space-y-2">
                    <p><span class="font-medium">Nama:</span> {{ $order->user->name }}</p>
                    <p><span class="font-medium">Email:</span> {{ $order->user->email }}</p>
                    <p><span class="font-medium">Alamat:</span> {{ $order->user->alamat ?? 'Tidak ada alamat' }}</p>
                </div>
            </div>
        </div>

        <div class="border rounded-lg p-4">
            <h2 class="text-lg font-semibold mb-4">Item Pesanan</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Menu</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($order->orderItems as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->kuliner->nama }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->quantity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right font-medium">Total:</td>
                            <td class="px-6 py-4 whitespace-nowrap font-bold">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="inline-flex">
                @csrf
                @method('PATCH')
                <select name="status" 
                        onchange="this.form.submit()"
                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="diantar" {{ $order->status === 'diantar' ? 'selected' : '' }}>Diantar</option>
                    <option value="sukses" {{ $order->status === 'sukses' ? 'selected' : '' }}>Sukses</option>
                    <option value="batal" {{ $order->status === 'batal' ? 'selected' : '' }}>Batal</option>
                </select>
            </form>
        </div>
    </div>
</div>
@endsection

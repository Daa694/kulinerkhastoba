@extends('layouts.app')

@section('content')
<div id="receiptModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="receipt-modal" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <!-- Receipt content -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <!-- Receipt Header -->
                <div class="text-center border-b pb-4">
                    <h1 class="text-2xl font-bold text-[#2E5A43]">Toba Taste</h1>
                    <p class="text-gray-600">Struk Pembayaran</p>
                </div>

                <!-- Order Details -->
                <div class="mt-4">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-gray-600">No. Pesanan:</p>
                            <p class="font-bold">{{ $order->order_id }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Tanggal:</p>
                            <p>{{ $order->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Customer Info -->
                <div class="mt-4">
                    <h3 class="font-bold text-gray-700">Informasi Pelanggan</h3>
                    <div class="mt-2">
                        <p><span class="text-gray-600">Nama:</span> {{ $order->user->name }}</p>
                        <p><span class="text-gray-600">Email:</span> {{ $order->user->email }}</p>
                        <p><span class="text-gray-600">Alamat:</span> {{ $order->user->alamat }}</p>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="mt-4">
                    <h3 class="font-bold text-gray-700 mb-2">Detail Pesanan</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="text-left text-xs font-medium text-gray-500">Item</th>
                                    <th class="text-center text-xs font-medium text-gray-500">Qty</th>
                                    <th class="text-right text-xs font-medium text-gray-500">Harga</th>
                                    <th class="text-right text-xs font-medium text-gray-500">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($order->orderItems as $item)
                                <tr>
                                    <td class="text-sm">{{ $item->kuliner->nama }}</td>
                                    <td class="text-center text-sm">{{ $item->quantity }}</td>
                                    <td class="text-right text-sm">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="text-right text-sm">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right pt-4 font-bold">Total:</td>
                                    <td class="text-right pt-4 font-bold">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Payment Info -->
                <div class="mt-4">
                    <h3 class="font-bold text-gray-700 mb-2">Informasi Pembayaran</h3>
                    <p><span class="text-gray-600">Metode:</span> {{ strtoupper($order->payment_type ?? '-') }}</p>
                    <p>
                        <span class="text-gray-600">Status:</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            LUNAS
                        </span>
                    </p>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="window.print()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-[#2E5A43] text-base font-medium text-white hover:bg-[#234434] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2E5A43] sm:ml-3 sm:w-auto sm:text-sm">
                    Cetak Struk
                </button>
                <button type="button" onclick="closeReceiptModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #receiptModal, #receiptModal * {
            visibility: visible;
        }
        #receiptModal {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        #receiptModal button {
            display: none;
        }
    }
</style>

<script>
    function closeReceiptModal() {
        const modal = document.getElementById('receiptModal');
        modal.classList.add('hidden');
    }
</script>
@endsection

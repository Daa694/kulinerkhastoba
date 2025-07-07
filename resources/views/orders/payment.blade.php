@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-4">Pembayaran Order #{{ $order->order_id }}</h2>
        
        <div class="mb-4">
            <p class="text-gray-600">Total Pembayaran:</p>
            <p class="text-2xl font-bold text-green-600">Rp {{ number_format($order->gross_amount, 0, ',', '.') }}</p>
        </div>

        <button 
            id="pay-button"
            class="w-full bg-[#2E5A43] text-white px-6 py-3 rounded hover:bg-[#244934]"
        >
            Bayar Sekarang
        </button>
    </div>
</div>

@push('scripts')
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    const payButton = document.querySelector('#pay-button');
    const snapToken = "{{ $snapToken }}";
    
    payButton.addEventListener('click', function() {
        window.snap.pay(snapToken, {
            onSuccess: function(result) {
                // Simpan response dari Midtrans
                fetch('/payment/finish', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(result)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Redirect ke halaman struk jika pembayaran berhasil
                        window.location.href = /orders/${result.order_id}/receipt;
                    } else {
                        window.location.href = '/orders';
                    }
                });
            },
            onPending: function(result) {
                alert('Pembayaran dalam proses. Silakan cek status pesanan Anda.');
                window.location.href = '/orders';
            },
            onError: function(result) {
                alert('Pembayaran gagal! ' + result.status_message);
                window.location.href = '/orders';
            },
            onClose: function() {
                if (!confirm('Anda yakin ingin menutup halaman pembayaran?')) {
                    window.snap.pay(snapToken);
                } else {
                    window.location.href = '/orders';
                }
            }
        });
    });
</script>
@endpush
@endsection
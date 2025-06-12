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
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-llJS8ZDaKY7O2Nm3"></script>
<script type="text/javascript">
    const payButton = document.querySelector('#pay-button');
    const snapToken = "{{ $snapToken }}";
    
    payButton.addEventListener('click', function() {
        window.snap.pay(snapToken, {
            onSuccess: function(result) {
                window.location.href = '/orders';
            },
            onPending: function(result) {
                window.location.href = '/orders';
            },
            onError: function(result) {
                alert('Pembayaran gagal!');
                window.location.href = '/orders';
            },
            onClose: function() {
                alert('Anda menutup popup tanpa menyelesaikan pembayaran');
            }
        });
    });
</script>
@endpush
@endsection

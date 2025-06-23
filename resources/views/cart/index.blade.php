@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-[#2E5A43]">Keranjang Belanja</h1>
            <a href="{{ route('menu') }}" class="inline-flex items-center px-4 py-2 bg-[#2E5A43] text-white rounded-lg hover:bg-[#234434] transition-colors duration-300">
                <i class="fas fa-utensils mr-2"></i>
                <span>Lanjut Belanja</span>
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if(count($items) > 0)
            <div class="bg-white rounded-lg shadow-md p-4">
                <div id="cart-items">
                    @foreach($items as $item)
                        <div class="flex items-center border-b py-3 last:border-b-0" id="cart-item-{{ $item->id }}">
                            <div class="flex-shrink-0 w-16 h-16">
                                @if($item->kuliner->gambar)
                                    <img src="{{ Storage::url($item->kuliner->gambar) }}"
                                         alt="{{ $item->kuliner->nama }}"
                                         class="w-full h-full object-cover rounded">
                                @endif
                            </div>
                            
                            <div class="ml-3 flex-grow">
                                <h3 class="font-semibold text-base">{{ $item->kuliner->nama }}</h3>
                                <div class="flex items-center space-x-4 mt-1">
                                    <div class="flex items-center space-x-2">
                                        <label class="text-sm text-gray-600">Jumlah:</label>
                                        <div class="flex items-center border rounded">
                                            <button type="button" 
                                                    onclick="updateQuantity({{ $item->id }}, Math.max(1, parseInt(document.getElementById('quantity-' + {{ $item->id }}).value) - 1))"
                                                    class="px-2 py-1 text-gray-600 hover:bg-gray-100">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="number" 
                                                   id="quantity-{{ $item->id }}"
                                                   value="{{ $item->quantity }}" 
                                                   min="1"
                                                   max="{{ $item->kuliner->stok }}"
                                                   onchange="updateQuantity({{ $item->id }}, this.value)"
                                                   class="w-16 text-center border-x px-2 py-1">
                                            <button type="button"
                                                    onclick="updateQuantity({{ $item->id }}, Math.min({{ $item->kuliner->stok }}, parseInt(document.getElementById('quantity-' + {{ $item->id }}).value) + 1))"
                                                    class="px-2 py-1 text-gray-600 hover:bg-gray-100">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <span class="text-base font-bold text-[#D2552D]" id="subtotal-{{ $item->id }}">
                                        Rp {{ number_format($item->kuliner->harga * $item->quantity, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="ml-2">
                                <button onclick="removeItem({{ $item->id }})"
                                        class="text-red-500 hover:text-red-700 p-1">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 border-t pt-4">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-lg font-bold">Total:</span>
                        <span class="text-xl font-bold text-[#D2552D]" id="cart-total">
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </span>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button onclick="placeOrder()" 
                                class="bg-[#2E5A43] text-white px-6 py-2 rounded hover:bg-[#244934] transition duration-200">
                            Bayar Sekarang
                        </button>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <div class="text-gray-500 mb-4">
                    <i class="fas fa-shopping-cart text-4xl mb-4"></i>
                    <p class="text-xl">Keranjang belanja Anda kosong</p>
                </div>
                <a href="{{ route('menu') }}" 
                   class="inline-flex items-center px-6 py-3 bg-[#2E5A43] text-white rounded-lg hover:bg-[#234434] transition-colors duration-300">
                    <i class="fas fa-utensils mr-2"></i>
                    <span>Mulai Belanja</span>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-llJS8ZDaKY7O2Nm3"></script>

<script>
function formatRupiah(amount) {
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
}

function updateQuantity(cartId, quantity) {
    quantity = parseInt(quantity);
    if (quantity < 1) return;    fetch('{{ route('cart.update') }}', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            cart_id: cartId,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update quantity input
            document.getElementById('quantity-' + cartId).value = quantity;
            
            // Update total
            document.getElementById('cart-total').textContent = formatRupiah(data.total);
            
            // Show success message
            const successAlert = document.createElement('div');
            successAlert.className = 'bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4';
            successAlert.textContent = data.message;
            document.querySelector('.container').insertBefore(successAlert, document.querySelector('.container').firstChild);
            
            // Remove success message after 3 seconds
            setTimeout(() => successAlert.remove(), 3000);
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal mengupdate keranjang');
    });
}

function removeItem(cartId) {
    if (!confirm('Apakah Anda yakin ingin menghapus item ini?')) {
        return;
    }

    fetch(`{{ url('cart') }}/${cartId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal menghapus item');
    });
}

function placeOrder() {
        fetch('{{ route('order.place') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {            snap.pay(data.snap_token, {
                onSuccess: function(result) {
                    console.log('Payment success:', result);
                    // Redirect to finish URL from Midtrans
                    window.location.href = result.finish_redirect_url;
                },
                onPending: function(result) {
                    console.log('Payment pending:', result);
                    window.location.href = result.finish_redirect_url;
                },
                onError: function(result) {
                    console.log('Payment error:', result);
                    alert('Pembayaran gagal');
                    window.location.href = '{{ route('orders.index') }}';
                },
                onClose: function() {
                    console.log('Payment widget closed');
                    alert('Anda menutup popup pembayaran sebelum menyelesaikan pembayaran');
                }
                });
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal membuat pesanan');
        });
    }

    function checkPaymentStatus(orderId) {
        // Poll for payment status and receipt URL
        let attempts = 0;
        const maxAttempts = 10;
        const interval = setInterval(() => {
            if (attempts >= maxAttempts) {
                clearInterval(interval);
                window.location.href = '{{ route('orders.index') }}';
                return;
            }
            
            fetch(`/orders/${orderId}/check-status`, {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.receipt_url) {
                    clearInterval(interval);
                    // Open receipt in new window
                    window.open(data.receipt_url, '_blank');
                    // Redirect to orders page
                    window.location.href = '{{ route('orders.index') }}';
                }
            });
            
            attempts++;
        }, 2000); // Check every 2 seconds
    }
</script>
@endpush
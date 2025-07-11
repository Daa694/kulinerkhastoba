@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-[#2E5A43] mb-2">Keranjang Belanja</h1>
        <p class="text-gray-600">Periksa kembali pesanan Anda sebelum checkout</p>
    </div>

    @if(count($items) > 0)
        <form action="{{ route('cart.checkout') }}" method="POST" id="cart-form">
            @csrf
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-6">
                    <ul class="divide-y divide-gray-100">
                        @foreach($items as $item)
                            <li class="py-6 first:pt-0 last:pb-0">
                                <div class="flex flex-col sm:flex-row items-center sm:space-x-6 space-y-4 sm:space-y-0">
                                    <div class="flex-shrink-0 w-32 h-32 rounded-lg overflow-hidden group">
                                        @if($item->kuliner->gambar_kuliner)
                                            <img src="{{ asset('images/' . $item->kuliner->gambar_kuliner) }}" 
                                                 alt="{{ $item->kuliner->nama }}" 
                                                 class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                                        @else
                                            <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                                <i class="fas fa-image text-gray-400 text-3xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0 w-full">
                                        <h3 class="text-xl font-bold text-gray-900 mb-2 hover:text-[#2E5A43] transition-colors duration-300">
                                            {{ $item->kuliner->nama }}
                                        </h3>
                                        <p class="text-gray-500 line-clamp-2 mb-4">{{ $item->kuliner->deskripsi }}</p>
                                        <div class="flex flex-col sm:flex-row items-center justify-between">
                                            <div class="flex items-center space-x-4 mb-2 sm:mb-0">
                                                <div class="flex items-center border border-gray-300 rounded-lg">
                                                    <label for="quantity_{{ $item->kuliner_id }}" class="sr-only">Jumlah</label>
                                                    <button type="button" 
                                                            class="w-10 h-10 flex items-center justify-center text-gray-600 hover:text-[#D2552D] hover:bg-gray-50 rounded-l-lg transition-colors duration-300 min-w-10"
                                                            onclick="updateQuantity(this, -1)"
                                                            @if($item->jumlah == 1) disabled style='opacity:0.5;cursor:not-allowed' @endif
                                                            aria-label="Kurangi jumlah">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <input type="number" 
                                                           id="quantity_{{ $item->kuliner_id }}"
                                                           name="quantity[{{ $item->kuliner_id }}]" 
                                                           value="{{ $item->jumlah }}" 
                                                           min="1"
                                                           class="w-16 h-10 text-center border-x border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#2E5A43]/20"
                                                           data-id="{{ $item->kuliner_id }}"
                                                           oninput="updatePrices(this)">
                                                    <button type="button" 
                                                            class="w-10 h-10 flex items-center justify-center text-gray-600 hover:text-[#D2552D] hover:bg-gray-50 rounded-r-lg transition-colors duration-300 min-w-10"
                                                            onclick="updateQuantity(this, 1)"
                                                            aria-label="Tambah jumlah">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                                <button type="button" 
                                                        onclick="removeItem({{ $item->kuliner_id }})"
                                                        class="text-gray-400 hover:text-red-500 transition-colors duration-300"
                                                        aria-label="Hapus item">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                            <div class="text-right w-full sm:w-auto">
                                                <div class="text-sm text-gray-500 mb-1">Harga satuan:</div>
                                                <div class="text-lg font-semibold text-[#D2552D]">
                                                    Rp {{ number_format($item->kuliner->harga, 0, ',', '.') }}
                                                </div>
                                                <div class="text-sm text-gray-500 mt-1">
                                                    Subtotal: <span class="font-medium text-gray-900" id="subtotal_{{ $item->kuliner_id }}">
                                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                    <div class="flex flex-col sm:flex-row items-center justify-between">
                        <div>
                            <p class="text-gray-600">Total Items: <span class="font-medium text-gray-900">{{ $items->count() }}</span></p>
                        </div>
                        <div class="text-right">
                            <p class="text-gray-600 mb-1">Total:</p>
                            <p class="text-2xl font-bold text-[#D2552D]">
                                Rp <span id="total-price">{{ number_format($total, 0, ',', '.') }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="mt-6 flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-4">
                        <a href="{{ route('menu') }}" 
                           class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-300 flex items-center justify-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Lanjut Belanja
                        </a>
                        <button type="submit" 
                                class="px-8 py-3 bg-[#2E5A43] text-white rounded-lg hover:bg-[#234434] transform hover:scale-105 transition-all duration-300 flex items-center justify-center relative"
                                id="checkout-btn">
                            <span>Checkout</span>
                            <i class="fas fa-arrow-right ml-2"></i>
                            <span id="checkout-spinner" class="hidden absolute right-4"><i class="fas fa-spinner fa-spin"></i></span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    @else
        <div class="text-center py-16 bg-white rounded-xl shadow-lg">
            <div class="mb-6 flex justify-center">
                <img src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png" alt="Empty Cart" class="w-24 h-24 mx-auto opacity-80">
            </div>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Keranjang Anda Kosong</h2>
            <p class="text-gray-600 mb-8">Jelajahi menu kami dan temukan makanan favorit Anda</p>
            <a href="{{ route('menu') }}" 
               class="inline-flex items-center px-6 py-3 bg-[#2E5A43] text-white rounded-lg hover:bg-[#234434] transform hover:scale-105 transition-all duration-300">
                <i class="fas fa-utensils mr-2"></i>
                Lihat Menu
            </a>
        </div>
    @endif
</div>

@push('scripts')
<script>
function updateQuantity(button, change) {
    const input = button.parentElement.querySelector('input');
    let newValue = parseInt(input.value) + change;
    if (newValue < 1) newValue = 1;
    input.value = newValue;
    updatePrices(input);
    // Disable minus button if quantity = 1
    const minusBtn = button.parentElement.querySelector('button[onclick*="-1"]');
    if (minusBtn) {
        if (parseInt(input.value) === 1) {
            minusBtn.disabled = true;
            minusBtn.style.opacity = 0.5;
            minusBtn.style.cursor = 'not-allowed';
        } else {
            minusBtn.disabled = false;
            minusBtn.style.opacity = 1;
            minusBtn.style.cursor = 'pointer';
        }
    }
}

function updatePrices(input) {
    const id = input.dataset.id;
    const quantity = input.value;
    showLoading(true);
    fetch(`/cart/ajax-update`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            id: id,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById(`subtotal_${id}`).textContent = 
                'Rp ' + new Intl.NumberFormat('id-ID').format(data.subtotal);
            document.getElementById('total-price').textContent = 
                new Intl.NumberFormat('id-ID').format(data.total);
            // Animate the price change
            const elements = [
                document.getElementById(`subtotal_${id}`),
                document.getElementById('total-price')
            ];
            elements.forEach(el => {
                el.classList.add('text-[#D2552D]');
                setTimeout(() => el.classList.remove('text-[#D2552D]'), 300);
            });
        }
        showLoading(false);
    })
    .catch(error => {
        showLoading(false);
        console.error('Error:', error);
    });
}

function removeItem(id) {
    if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
        showLoading(true);
        fetch(`/cart/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            showLoading(false);
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            showLoading(false);
            console.error('Error:', error);
        });
    }
}

function showLoading(show) {
    const spinner = document.getElementById('checkout-spinner');
    if (spinner) spinner.classList.toggle('hidden', !show);
}

// Spinner on checkout
document.addEventListener('DOMContentLoaded', function() {
    const checkoutBtn = document.getElementById('checkout-btn');
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', function() {
            showLoading(true);
            setTimeout(() => showLoading(false), 2000); // fallback
        });
    }
});
</script>
<style>
@keyframes priceChange {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}
.text-[#D2552D] {
    animation: priceChange 0.3s ease;
}
@media (max-width: 640px) {
    .sm\\:flex-row { flex-direction: column !important; }
    .sm\\:space-x-6 { margin-right: 0 !important; }
    .sm\\:mb-0 { margin-bottom: 0 !important; }
    .sm\\:w-auto { width: 100% !important; }
}
</style>
@endpush
@endsection

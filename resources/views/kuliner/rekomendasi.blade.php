@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-[#D2552D] mb-2 flex items-center gap-3">
            <i class="fas fa-fire text-2xl text-[#D2552D]"></i> Kuliner Terlaris
        </h1>
        <p class="text-gray-600">10 menu dengan penjualan terbanyak sepanjang waktu</p>
    </div>
    
    @if($kuliners->isEmpty())
        <div class="text-center py-10">
            <p class="text-gray-600 mb-4">Belum ada menu yang direkomendasikan</p>
            <a href="{{ route('menu') }}" class="inline-block bg-[#2E5A43] text-white px-6 py-2 rounded-lg hover:bg-[#244934] transition-colors duration-300">
                <i class="fas fa-utensils mr-2"></i>Lihat Semua Menu
            </a>
        </div>
    @else
        <!-- Carousel Navigation -->
        <div class="flex justify-end space-x-2 mb-4">
            <button id="btnLeft" onclick="slideLeft()" class="p-2 rounded-full bg-[#D2552D] text-white hover:bg-[#b9431c] transition-all duration-300 shadow-lg hover:shadow-xl disabled:opacity-40 disabled:cursor-not-allowed">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button id="btnRight" onclick="slideRight()" class="p-2 rounded-full bg-[#D2552D] text-white hover:bg-[#b9431c] transition-all duration-300 shadow-lg hover:shadow-xl disabled:opacity-40 disabled:cursor-not-allowed">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>

        <!-- Carousel Container -->
        <div class="relative overflow-hidden">
            <div id="slider" class="flex space-x-6 transition-transform duration-500 ease-out">
                @foreach($kuliners as $kuliner)
                    <div class="flex-none w-[320px]">
                        <div class="bg-gradient-to-br from-[#fff7f3] to-[#ffe5d0] rounded-3xl shadow-2xl border-4 border-[#D2552D]/60 overflow-hidden flex flex-col group h-full hover:shadow-2xl transition-all duration-300 relative">
                            <div class="relative w-full h-48 flex items-center justify-center overflow-hidden">
                                <img src="{{ Storage::url($kuliner->gambar) }}" alt="{{ $kuliner->nama }}" class="object-cover w-full h-full transition-transform duration-700 group-hover:scale-105 rounded-t-3xl border-b-2 border-[#D2552D]/30">
                                <div class="absolute top-3 left-3 z-10">
                                    <span class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-[#D2552D] to-[#F2994A] text-white rounded-full text-xs font-bold shadow">
                                        <i class="fas fa-fire text-yellow-300 mr-1"></i> Terlaris
                                    </span>
                                </div>
                                <div class="absolute top-3 right-3 z-10 flex items-center bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full shadow-lg">
                                    <i class="fas fa-star text-yellow-400 mr-1"></i>
                                    <span class="font-semibold text-[#D2552D] text-base">
                                        {{ number_format($kuliner->ratings_avg_rating ?? 0, 1) }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-5 flex-1 flex flex-col justify-between">
                                <h3 class="text-xl font-extrabold text-[#2E5A43] mb-2 text-center group-hover:text-[#D2552D] transition-colors duration-300">{{ $kuliner->nama }}</h3>
                                <div class="flex items-center justify-between mb-2 px-2">
                                    <span class="text-[#D2552D] font-bold text-lg">
                                        Rp {{ number_format($kuliner->harga, 0, ',', '.') }}
                                    </span>
                                    <span class="text-gray-500 text-xs italic flex items-center gap-1">
                                        <i class="fas fa-star text-yellow-400"></i>
                                        {{ $kuliner->ratings->count() }} rating
                                    </span>
                                </div>
                                <div class="flex items-center justify-between mb-2 px-2">
                                    <span class="text-gray-600 text-xs flex items-center gap-1">
                                        <i class="fas fa-box-open"></i> Stok: {{ $kuliner->stok }}
                                    </span>
                                    <span class="text-gray-600 text-xs flex items-center gap-1">
                                        <i class="fas fa-shopping-basket"></i> Terjual: {{ $kuliner->order_items_sum_quantity ?? 0 }}
                                    </span>
                                </div>
                                <span class="block w-full text-center px-4 py-2 bg-gradient-to-r from-[#2E5A43] to-[#4CAF50] text-white rounded-lg font-semibold hover:from-[#234732] hover:to-[#357a38] transition-colors duration-300 shadow-md mt-2 pointer-events-none opacity-80">Lihat Detail</span>
                            </div>
                            <a href="{{ route('menu.detail', $kuliner) }}" class="absolute inset-0 z-10"></a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
    animation: fadeIn 0.5s ease-out forwards;
}

/* Hide scrollbar but keep functionality */
#slider {
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;     /* Firefox */
}

#slider::-webkit-scrollbar {
    display: none;            /* Chrome, Safari and Opera */
}
</style>

<script>
const slider = document.getElementById('slider');
const slideWidth = 324; // 300px card + 24px gap
let currentPosition = 0;

const btnLeft = document.getElementById('btnLeft');
const btnRight = document.getElementById('btnRight');

function updateButtonState() {
    const maxScroll = slider.scrollWidth - slider.clientWidth;
    btnLeft.disabled = currentPosition <= 0;
    btnRight.disabled = currentPosition >= maxScroll - 2; // -2 agar tidak mentok pixel rounding
}

function slideLeft() {
    const maxScroll = slider.scrollWidth - slider.clientWidth;
    currentPosition = Math.max(currentPosition - slideWidth, 0);
    slider.style.transform = `translateX(-${currentPosition}px)`;
    updateButtonState();
}

function slideRight() {
    const maxScroll = slider.scrollWidth - slider.clientWidth;
    currentPosition = Math.min(currentPosition + slideWidth, maxScroll);
    slider.style.transform = `translateX(-${currentPosition}px)`;
    updateButtonState();
}

// Optional: Add touch/swipe support
let touchStart = null;
let touchPosition = null;

slider.addEventListener('touchstart', function(e) {
    touchStart = e.touches[0].clientX;
    touchPosition = currentPosition;
});

slider.addEventListener('touchmove', function(e) {
    if (!touchStart) return;
    const diff = touchStart - e.touches[0].clientX;
    const maxScroll = slider.scrollWidth - slider.clientWidth;
    currentPosition = Math.max(0, Math.min(touchPosition + diff, maxScroll));
    slider.style.transform = `translateX(-${currentPosition}px)`;
    updateButtonState();
});

slider.addEventListener('touchend', function() {
    touchStart = null;
    // Snap to nearest card
    const cardPosition = Math.round(currentPosition / slideWidth) * slideWidth;
    currentPosition = cardPosition;
    slider.style.transform = `translateX(-${currentPosition}px)`;
    updateButtonState();
});

// Optional: Add keyboard navigation
document.addEventListener('keydown', function(e) {
    if (e.key === 'ArrowLeft') slideLeft();
    if (e.key === 'ArrowRight') slideRight();
});

// Inisialisasi state button saat load
updateButtonState();
</script>
@endsection
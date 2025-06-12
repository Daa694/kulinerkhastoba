@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-[#2E5A43] mb-2">Menu Rekomendasi</h1>
        <p class="text-gray-600">Menu terbaik berdasarkan rating pelanggan kami</p>
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
            <button onclick="slideLeft()" class="p-2 rounded-full bg-[#2E5A43] text-white hover:bg-[#244934] transition-all duration-300 shadow-lg hover:shadow-xl">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button onclick="slideRight()" class="p-2 rounded-full bg-[#2E5A43] text-white hover:bg-[#244934] transition-all duration-300 shadow-lg hover:shadow-xl">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>

        <!-- Carousel Container -->
        <div class="relative overflow-hidden">
            <div id="slider" class="flex space-x-6 transition-transform duration-500 ease-out">
                @foreach($kuliners as $kuliner)
                    <div class="flex-none w-[300px]">
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden group hover:shadow-xl transition-all duration-300 h-full">
                            <div class="relative pt-[60%] overflow-hidden">
                                @if($kuliner->gambar)
                                    <img src="{{ Storage::url($kuliner->gambar) }}" 
                                         alt="{{ $kuliner->nama }}" 
                                         class="absolute inset-0 w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                                @else
                                    <div class="absolute inset-0 bg-gray-100 flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400 text-4xl"></i>
                                    </div>
                                @endif
                                
                                <!-- Rating Badge -->
                                <div class="absolute top-4 right-4">
                                    <div class="flex items-center bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full shadow-lg">
                                        <i class="fas fa-star text-yellow-400"></i>
                                        <span class="ml-1 font-bold">
                                            {{ number_format($kuliner->ratings_avg_rating ?? 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="p-5">
                                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-[#2E5A43] transition-colors duration-300">
                                    {{ $kuliner->nama }}
                                </h3>
                                <p class="text-gray-600 mb-4 line-clamp-2">{{ $kuliner->deskripsi }}</p>
                                
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-xl font-bold text-[#D2552D]">
                                        Rp {{ number_format($kuliner->harga, 0, ',', '.') }}
                                    </span>
                                    <span class="text-sm text-gray-500">
                                        {{ $kuliner->ratings->count() }} ulasan
                                    </span>
                                </div>

                                <div class="flex items-center space-x-2">
                                    <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                        @csrf
                                        <input type="hidden" name="kuliner_id" value="{{ $kuliner->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" 
                                                class="w-full bg-[#2E5A43] text-white px-4 py-2 rounded-lg hover:bg-[#234434] transform hover:scale-105 transition-all duration-300 flex items-center justify-center space-x-2">
                                            <i class="fas fa-cart-plus"></i>
                                            <span>Tambah</span>
                                        </button>
                                    </form>
                                    <a href="{{ route('menu.detail', $kuliner) }}" 
                                       class="bg-gray-100 text-gray-700 p-2 rounded-lg hover:bg-gray-200 transition-colors duration-300">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                </div>
                            </div>
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

function slideLeft() {
    const maxScroll = slider.scrollWidth - slider.clientWidth;
    currentPosition = Math.max(currentPosition - slideWidth, 0);
    slider.style.transform = `translateX(-${currentPosition}px)`;
}

function slideRight() {
    const maxScroll = slider.scrollWidth - slider.clientWidth;
    currentPosition = Math.min(currentPosition + slideWidth, maxScroll);
    slider.style.transform = `translateX(-${currentPosition}px)`;
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
});

slider.addEventListener('touchend', function() {
    touchStart = null;
    // Snap to nearest card
    const cardPosition = Math.round(currentPosition / slideWidth) * slideWidth;
    currentPosition = cardPosition;
    slider.style.transform = `translateX(-${currentPosition}px)`;
});

// Optional: Add keyboard navigation
document.addEventListener('keydown', function(e) {
    if (e.key === 'ArrowLeft') slideLeft();
    if (e.key === 'ArrowRight') slideRight();
});
</script>
@endsection
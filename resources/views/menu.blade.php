@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden">
    <!-- Background Image -->
    <div class="absolute inset-0">
        <img src="{{ asset('images/danautoba.webp') }}" alt="Danau Toba" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-[#2E5A43]/80 backdrop-blur-sm"></div>
    </div>
    <!-- Background Pattern for texture -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.4\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>
    
    <div class="w-full max-w-[90%] mx-auto px-4 py-16 relative">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">>
            <!-- Text Content -->
            <div class="text-white space-y-6 md:pr-12">
                <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                    Temukan Cita Rasa<br>
                    <span class="text-[#D2552D]">Kuliner Khas Toba</span>
                </h1>
                <p class="text-lg text-gray-100 leading-relaxed">
                    Nikmati berbagai pilihan hidangan autentik dengan cita rasa yang khas. 
                    Dibuat dengan bahan-bahan berkualitas dan resep tradisional.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="#menu-items" class="inline-flex items-center px-6 py-3 bg-[#D2552D] text-white rounded-lg hover:bg-[#bf4a28] transform hover:scale-105 transition-all duration-300">
                        <i class="fas fa-utensils mr-2"></i>
                        <span>Lihat Menu</span>
                    </a>
                    <a href="{{ route('rekomendasi') }}" class="inline-flex items-center px-6 py-3 bg-white/10 text-white rounded-lg hover:bg-white/20 backdrop-blur-sm transform hover:scale-105 transition-all duration-300">
                        <i class="fas fa-star mr-2"></i>
                        <span>Menu Favorit</span>
                    </a>
                </div>
                <!-- Features -->
                <div class="grid grid-cols-2 gap-4 pt-4">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-white/10 rounded-lg backdrop-blur-sm">
                            <i class="fas fa-check text-[#D2552D]"></i>
                        </div>
                        <span>100% Autentik</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-white/10 rounded-lg backdrop-blur-sm">
                            <i class="fas fa-truck text-[#D2552D]"></i>
                        </div>
                        <span>Pengiriman Cepat</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-white/10 rounded-lg backdrop-blur-sm">
                            <i class="fas fa-shield-alt text-[#D2552D]"></i>
                        </div>
                        <span>Kualitas Terjamin</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-white/10 rounded-lg backdrop-blur-sm">
                            <i class="fas fa-heart text-[#D2552D]"></i>
                        </div>
                        <span>Pelayanan Terbaik</span>
                    </div>
                </div>
            </div>
            
            <!-- Top 3 Rated Menu Grid -->
            <!-- Top 3 Rated Menu Slider (Modern, Animated, 3 Gambar) -->
            <div class="w-full">
                @if($topRatedKuliners->count())
                <div class="relative flex flex-col items-center">
                    <div class="mb-3 text-center">
                        <h2 class="text-2xl md:text-3xl font-bold text-[#D2552D] tracking-wide mb-1">Menu Paling Populer</h2>
                        <p class="text-gray-700 text-base md:text-lg">3 Kuliner dengan rating tertinggi pilihan pelanggan</p>
                    </div>
                    <div id="populer-slider" class="flex overflow-hidden w-full max-w-2xl mx-auto relative" style="height: 270px;">
                        @foreach($topRatedKuliners->take(4) as $i => $populer)
                        <div class="populer-slide w-full absolute left-0 top-0 transition-all duration-700 ease-in-out cursor-pointer"
                             style="z-index:{{ 10 - $i }}; opacity:0; transform:scale(0.9) translateX(40px);"
                             onclick="window.location='{{ route('menu.detail', $populer) }}'">
                            <div class="bg-gradient-to-br from-[#fff7f3] to-[#ffe5d0] rounded-3xl shadow-2xl border-4 border-[#D2552D]/60 overflow-hidden flex flex-col group h-full">
                                <div class="relative w-full h-44 flex items-center justify-center overflow-hidden">
                                    <img src="{{ Storage::url($populer->gambar) }}" alt="{{ $populer->nama }}" class="object-cover w-full h-full transition-transform duration-700 group-hover:scale-105 rounded-t-3xl border-b-2 border-[#D2552D]/30">
                                    <div class="absolute top-3 left-3 z-10">
                                        <span class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-[#D2552D] to-[#F2994A] text-white rounded-full text-xs font-bold shadow">
                                            <i class="fas fa-crown text-yellow-300 mr-1"></i> Populer
                                        </span>
                                    </div>
                                    <div class="absolute top-3 right-3 z-10 flex items-center bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full shadow-lg">
                                        <i class="fas fa-star text-yellow-400 mr-1"></i>
                                        <span class="font-semibold text-[#D2552D] text-base">
                                            {{ number_format($populer->ratings_avg_rating ?? 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="p-5 flex-1 flex flex-col justify-between">
                                    <h3 class="text-xl font-extrabold text-[#2E5A43] mb-2 text-center group-hover:text-[#D2552D] transition-colors duration-300">{{ $populer->nama }}</h3>
                                    <div class="flex items-center justify-between mb-2 px-2">
                                        <span class="text-[#D2552D] font-bold text-lg">
                                            Rp {{ number_format($populer->harga, 0, ',', '.') }}
                                        </span>
                                        <span class="text-gray-500 text-xs italic flex items-center gap-1">
                                            <i class="fas fa-star text-yellow-400"></i>
                                            {{ $populer->ratings->count() }} rating
                                        </span>
                                    </div>
                                    <span class="block w-full text-center px-4 py-2 bg-gradient-to-r from-[#2E5A43] to-[#4CAF50] text-white rounded-lg font-semibold hover:from-[#234732] hover:to-[#357a38] transition-colors duration-300 shadow-md mt-2 pointer-events-none opacity-80">Lihat Detail</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <!-- Slider Dots -->
                    <div class="flex justify-center mt-4 space-x-2">
                        @foreach($topRatedKuliners->take(4) as $i => $populer)
                        <button class="w-3 h-3 rounded-full bg-[#D2552D] opacity-40 border-2 border-[#D2552D] transition-all duration-300 slider-dot" data-index="{{ $i }}"></button>
                        @endforeach
                    </div>
                    <button id="populer-prev" class="absolute left-0 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-[#D2552D] hover:text-white text-[#D2552D] rounded-full shadow-lg w-10 h-10 flex items-center justify-center z-20 transition-all duration-300"><i class="fas fa-chevron-left"></i></button>
                    <button id="populer-next" class="absolute right-0 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-[#D2552D] hover:text-white text-[#D2552D] rounded-full shadow-lg w-10 h-10 flex items-center justify-center z-20 transition-all duration-300"><i class="fas fa-chevron-right"></i></button>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const slides = document.querySelectorAll('#populer-slider .populer-slide');
                            const dots = document.querySelectorAll('.slider-dot');
                            let index = 0;
                            let interval = null;
                            function showSlide(i) {
                                slides.forEach((slide, idx) => {
                                    if(idx === i) {
                                        slide.style.opacity = 1;
                                        slide.style.transform = 'scale(1) translateX(0)';
                                        slide.style.zIndex = 10;
                                    } else {
                                        slide.style.opacity = 0;
                                        slide.style.transform = 'scale(0.9) translateX(40px)';
                                        slide.style.zIndex = 5;
                                    }
                                });
                                dots.forEach((dot, idx) => {
                                    dot.classList.toggle('opacity-100', idx === i);
                                    dot.classList.toggle('scale-125', idx === i);
                                    dot.classList.toggle('border-4', idx === i);
                                });
                            }
                            function nextSlide() {
                                index = (index + 1) % slides.length;
                                showSlide(index);
                            }
                            function prevSlide() {
                                index = (index - 1 + slides.length) % slides.length;
                                showSlide(index);
                            }
                            function startAutoSlide() {
                                interval = setInterval(nextSlide, 2500);
                            }
                            function stopAutoSlide() {
                                clearInterval(interval);
                            }
                            document.getElementById('populer-next').onclick = function() {
                                stopAutoSlide();
                                nextSlide();
                                startAutoSlide();
                            };
                            document.getElementById('populer-prev').onclick = function() {
                                stopAutoSlide();
                                prevSlide();
                                startAutoSlide();
                            };
                            dots.forEach((dot, idx) => {
                                dot.onclick = function() {
                                    stopAutoSlide();
                                    index = idx;
                                    showSlide(index);
                                    startAutoSlide();
                                };
                            });
                            showSlide(index);
                            startAutoSlide();
                        });
                    </script>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Search Results & Menu Section -->
<div id="menu-items" class="container mx-auto px-4 py-12">
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-md animate-fade-in-down">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-md animate-fade-in-down">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                <p>{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-[#2E5A43]">Menu Kuliner</h1>
            <p class="text-gray-600 mt-2">Temukan cita rasa kuliner khas Toba</p>
        </div>
        <div class="flex items-center space-x-4">
            <button class="bg-white px-4 py-2 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 flex items-center space-x-2 text-[#2E5A43]">
                <i class="fas fa-filter"></i>
                <span>Filter</span>
            </button>
            <form method="GET" action="{{ route('menu') }}">
    <div class="relative">
        <select name="sort" onchange="this.form.submit()" class="appearance-none bg-white px-4 py-2 pr-8 rounded-lg shadow-md hover:shadow-lg transition duration-300 text-[#2E5A43] cursor-pointer">
            <option value="">Urutkan</option>
            <option value="harga_asc" {{ request('sort') == 'harga_asc' ? 'selected' : '' }}>Harga: Rendah ke Tinggi</option>
            <option value="harga_desc" {{ request('sort') == 'harga_desc' ? 'selected' : '' }}>Harga: Tinggi ke Rendah</option>
            <option value="rating_desc" {{ request('sort') == 'rating_desc' ? 'selected' : '' }}>Rating Tertinggi</option>
            <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
        </select>
        <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-[#2E5A43]"></i>
    </div>
</form>

        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($kuliners as $kuliner)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:-translate-y-1 transition-all duration-300 flex flex-col group">
                <div class="relative pt-[75%] overflow-hidden"> <!-- 4:3 Aspect Ratio -->
                    @if($kuliner->gambar)
                        <img src="{{ Storage::url($kuliner->gambar) }}" 
                             alt="{{ $kuliner->nama }}" 
                             class="absolute top-0 left-0 w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                    @else
                        <div class="absolute top-0 left-0 w-full h-full bg-gray-100 flex items-center justify-center">
                            <i class="fas fa-image text-gray-400 text-4xl"></i>
                        </div>
                    @endif
                    
                    <div class="absolute top-4 right-4">
                        <div class="flex items-center bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full shadow-lg">
                            <i class="fas fa-star text-yellow-400 mr-1"></i>
                            <span class="font-medium">
                                {{ number_format($kuliner->ratings_avg_rating ?? 0, 1) }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="p-6 flex flex-col flex-grow">
                    <h2 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-[#2E5A43] transition-colors duration-300">
                        {{ $kuliner->nama }}
                    </h2>
                    
                    <p class="text-gray-600 mb-4 flex-grow line-clamp-2">{{ $kuliner->deskripsi }}</p>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-bold text-[#D2552D]">
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
                               class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transform hover:scale-105 transition-all duration-300 flex items-center justify-center space-x-2">
                                <i class="fas fa-info-circle mr-1"></i>
                                <span>Detail</span>
                            </a>
                        </div>
                        
                        <div class="text-sm text-gray-500 flex items-center">
                            <i class="fas fa-box-open mr-2"></i>
                            <span>Stok: {{ $kuliner->stok }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="text-center py-16 bg-white rounded-xl shadow-lg">
                    <div class="mb-6">
                        <i class="fas fa-utensils text-6xl text-gray-300"></i>
                    </div>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Tidak ada menu tersedia</h2>
                    <p class="text-gray-600">Silakan coba pencarian lain atau kembali lagi nanti</p>
                </div>
            </div>
        @endforelse
    </div>
</div>




<style>
@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-down {
    animation: fadeInDown 0.5s ease-out;
}

/* Hide scrollbar for Chrome, Safari and Opera */
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
/* Hide scrollbar for IE, Edge and Firefox */
.scrollbar-hide {
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;  /* Firefox */
}
</style>
@endsection



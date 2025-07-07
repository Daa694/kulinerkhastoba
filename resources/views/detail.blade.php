@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 animate-fade-in">
    <div class="max-w-7xl mx-auto">
        <!-- Back Button -->
        <a href="{{ url()->previous() }}" class="inline-flex items-center text-gray-600 hover:text-[#2E5A43] mb-8 group transition-colors duration-300">
            <i class="fas fa-arrow-left mr-2 transform group-hover:-translate-x-1 transition-transform duration-300"></i>
            <span>Kembali</span>
        </a>

        <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
            <div class="flex flex-col lg:flex-row gap-8 items-stretch">
                <!-- Gambar -->
                <div class="w-full lg:w-1/2 relative rounded-xl overflow-hidden bg-gray-100 min-h-[400px] group">
                    @if($kuliner->gambar)
                        <img src="{{ Storage::url($kuliner->gambar) }}" alt="{{ $kuliner->nama }}" class="w-full h-full max-h-[600px] object-cover object-center transition-transform duration-700 ease-in-out group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-200">
                            <i class="fas fa-image text-gray-400 text-6xl"></i>
                        </div>
                    @endif

                    <!-- Rating Badge -->
                    <div class="absolute top-4 right-4 flex flex-col items-end space-y-1 z-20">
                        <div class="bg-white/90 backdrop-blur-sm px-4 py-2 rounded-xl shadow-lg flex items-center space-x-3">
                            <i class="fas fa-star text-yellow-400 text-lg"></i>
                            <span class="ml-1 font-bold text-xl">
                                {{ number_format($kuliner->ratings_avg_rating ?? 0, 1) }}
                            </span>
                            <span class="text-sm text-gray-500">({{ $kuliner->ratings->count() }} ulasan)</span>
                        </div>
                        <span class="bg-[#D2552D] text-white text-xs font-semibold px-3 py-1 rounded-full shadow">Rating</span>
                    </div>
                </div>

                <!-- Konten Tulisan -->
                <div class="w-full lg:w-1/2 flex flex-col justify-between p-6 lg:p-10 bg-gradient-to-tr from-white to-[#f9f9f9]">
                    <div>
                        <h1 class="text-4xl font-extrabold text-[#2E5A43] mb-4">{{ $kuliner->nama }}</h1>
                        <p class="text-gray-700 text-lg leading-relaxed mb-2 italic line-clamp-4" id="deskripsi-singkat">{{ Str::limit(strip_tags($kuliner->deskripsi), 300, '...') }}</p>

                        <button onclick="toggleDeskripsi()" class="text-[#2E5A43] font-medium underline text-sm mb-4" id="toggle-btn">Lihat Selengkapnya</button>

                        <p class="hidden text-gray-700 text-base leading-relaxed mb-6 italic" id="deskripsi-panjang">{{ $kuliner->deskripsi }}</p>

                        <div class="flex items-center justify-between py-4 border-t border-b border-gray-200 mb-6">
                            <div>
                                <p class="text-gray-500 text-sm mb-1">Harga</p>
                                <p class="text-3xl font-bold text-[#D2552D]">
                                    Rp {{ number_format($kuliner->harga, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-gray-500 text-sm mb-1">Stok</p>
                                <p class="text-xl font-semibold {{ $kuliner->stok > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $kuliner->stok }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Form Tambah ke Keranjang -->
                    <form action="{{ route('cart.add') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="kuliner_id" value="{{ $kuliner->id }}">

                        <div class="flex items-center space-x-4">
                            <label class="text-gray-700 font-medium">Jumlah:</label>
                            <div class="flex items-center border border-gray-300 rounded-lg">
                                <button type="button" onclick="updateQuantity(-1)" class="w-10 h-10 flex items-center justify-center text-gray-600 hover:text-[#D2552D] hover:bg-gray-50 rounded-l-lg transition-colors duration-300">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $kuliner->stok }}" class="w-16 h-10 text-center border-x border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#2E5A43]/20">
                                <button type="button" onclick="updateQuantity(1)" class="w-10 h-10 flex items-center justify-center text-gray-600 hover:text-[#D2552D] hover:bg-gray-50 rounded-r-lg transition-colors duration-300">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-gradient-to-r from-[#2E5A43] to-[#3C7C5B] text-white px-6 py-3 rounded-xl hover:shadow-xl transform hover:scale-105 transition-all duration-300 flex items-center justify-center space-x-2">
                            <i class="fas fa-cart-plus"></i>
                            <span>Tambah ke Keranjang</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Reviews Section -->
            <div class="border-t border-gray-100">
                <div class="p-8 lg:p-10">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Ulasan Pelanggan</h2>

                    @auth
                        <div class="mb-8">
                            <form action="{{ route('rating.store', $kuliner) }}" method="POST" class="space-y-4">
                                @csrf
                                <input type="hidden" name="rating" id="rating-value" value="0">
                                <div class="bg-gray-50 rounded-xl p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Berikan Ulasan Anda</h3>

                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                                            <div class="flex items-center space-x-2 text-2xl text-yellow-400" id="star-container">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star text-gray-300 cursor-pointer transition" data-value="{{ $i }}"></i>
                                                @endfor
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Komentar</label>
                                            <textarea name="komentar" rows="3" class="w-full rounded-lg border-gray-300 focus:border-[#2E5A43] focus:ring focus:ring-[#2E5A43]/20 transition-shadow duration-200" placeholder="Bagikan pengalaman Anda...">{{ old('komentar') }}</textarea>
                                        </div>

                                        <button type="submit" class="bg-[#2E5A43] text-white px-6 py-2 rounded-lg hover:bg-[#234434] transform hover:scale-105 transition-all duration-300">
                                            Kirim Ulasan
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endauth

                    <div class="space-y-6">
                        @forelse($kuliner->ratings as $rating)
                            <div class="bg-white border border-gray-200 shadow-md rounded-xl p-5 transition-transform transform hover:-translate-y-1 hover:shadow-lg duration-300">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 rounded-full bg-[#2E5A43] flex items-center justify-center text-white font-bold text-lg shadow">
                                            {{ strtoupper(substr($rating->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <h4 class="text-base font-semibold text-gray-900">{{ $rating->user->name }}</h4>
                                            <p class="text-xs text-gray-400">{{ $rating->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <div class="flex space-x-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $rating->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                        @endfor
                                    </div>
                                </div>

                                @if($rating->komentar)
                                    <p class="mt-3 text-gray-700 text-sm leading-relaxed">{{ $rating->komentar }}</p>
                                @endif

                                @if(Auth::id() === $rating->user_id)
                                    <div class="mt-4 flex space-x-3 text-sm">
                                        <button onclick="editRating({{ $rating->id }})" class="flex items-center px-3 py-1 rounded-md border border-gray-300 hover:border-[#2E5A43] hover:text-[#2E5A43] transition duration-300">
                                            <i class="fas fa-edit mr-2"></i>Edit
                                        </button>
                                        <form action="{{ route('rating.destroy', $rating) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ulasan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="flex items-center px-3 py-1 rounded-md border border-gray-300 hover:border-red-500 hover:text-red-500 transition duration-300">
                                                <i class="fas fa-trash-alt mr-2"></i>Hapus
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-10">
                                <i class="fas fa-comment-alt text-5xl text-gray-300 mb-4"></i>
                                <p class="text-gray-500 text-sm">Belum ada ulasan untuk menu ini</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.line-clamp-4 {
    display: -webkit-box;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>

<script>
    function updateQuantity(delta) {
        const input = document.getElementById('quantity');
        let value = parseInt(input.value) || 1;
        value += delta;
        if (value < 1) value = 1;
        if (value > parseInt(input.max)) value = parseInt(input.max);
        input.value = value;
    }

    function toggleDeskripsi() {
        const singkat = document.getElementById('deskripsi-singkat');
        const panjang = document.getElementById('deskripsi-panjang');
        const btn = document.getElementById('toggle-btn');

        if (panjang.classList.contains('hidden')) {
            panjang.classList.remove('hidden');
            singkat.classList.add('hidden');
            btn.textContent = 'Sembunyikan';
        } else {
            panjang.classList.add('hidden');
            singkat.classList.remove('hidden');
            btn.textContent = 'Lihat Selengkapnya';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('#star-container i');
        const ratingInput = document.getElementById('rating-value');

        let currentRating = 0;

        stars.forEach((star, index) => {
            const rating = index + 1;

            star.addEventListener('mouseenter', () => {
                highlightStars(rating);
            });

            star.addEventListener('mouseleave', () => {
                highlightStars(currentRating);
            });

            star.addEventListener('click', () => {
                currentRating = rating;
                ratingInput.value = rating;
                highlightStars(rating);
            });
        });

        function highlightStars(rating) {
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.remove('text-gray-300');
                    star.classList.add('text-yellow-400');
                } else {
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-300');
                }
            });
        }
    });
</script>
@endsection

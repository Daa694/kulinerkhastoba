@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Back Button -->
        <a href="{{ url()->previous() }}" class="inline-flex items-center text-gray-600 hover:text-[#2E5A43] mb-8 group transition-colors duration-300">
            <i class="fas fa-arrow-left mr-2 transform group-hover:-translate-x-1 transition-transform duration-300"></i>
            <span>Kembali</span>
        </a>

        <div class="bg-white rounded-xl shadow-xl overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Image Section -->
                <div class="relative h-96 lg:h-full min-h-[500px]">
                    @if($kuliner->gambar)
                        <img src="{{ Storage::url($kuliner->gambar) }}" 
                             alt="{{ $kuliner->nama }}" 
                             class="absolute inset-0 w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                    @else
                        <div class="absolute inset-0 bg-gray-100 flex items-center justify-center">
                            <i class="fas fa-image text-gray-400 text-6xl"></i>
                        </div>
                    @endif
                    
                    <!-- Rating Badge -->
                    <div class="absolute top-4 right-4">
                        <div class="bg-white/90 backdrop-blur-sm px-4 py-2 rounded-xl shadow-lg flex items-center space-x-3">
                            <div class="flex items-center">
                                <i class="fas fa-star text-yellow-400 text-lg"></i>
                                <span class="ml-2 font-bold text-xl">
                                    {{ number_format($kuliner->ratings_avg_rating ?? 0, 1) }}
                                </span>
                            </div>
                            <span class="text-gray-600 text-sm">
                                ({{ $kuliner->ratings->count() }} ulasan)
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Content Section -->
                <div class="p-8 lg:p-10">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $kuliner->nama }}</h1>
                    
                    <div class="space-y-6">
                        <p class="text-gray-600 text-lg leading-relaxed">{{ $kuliner->deskripsi }}</p>
                        
                        <div class="flex items-center justify-between py-4 border-t border-b border-gray-100">
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

                        <!-- Add to Cart Form -->
                        <form action="{{ route('cart.add') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="kuliner_id" value="{{ $kuliner->id }}">
                            
                            <div class="flex items-center space-x-4">
                                <label class="text-gray-700 font-medium">Jumlah:</label>
                                <div class="flex items-center border border-gray-300 rounded-lg">
                                    <button type="button" 
                                            onclick="updateQuantity(-1)"
                                            class="w-10 h-10 flex items-center justify-center text-gray-600 hover:text-[#D2552D] hover:bg-gray-50 rounded-l-lg transition-colors duration-300">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    
                                    <input type="number" 
                                           name="quantity" 
                                           id="quantity"
                                           value="1" 
                                           min="1" 
                                           max="{{ $kuliner->stok }}"
                                           class="w-16 h-10 text-center border-x border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#2E5A43]/20">
                                           
                                    <button type="button" 
                                            onclick="updateQuantity(1)"
                                            class="w-10 h-10 flex items-center justify-center text-gray-600 hover:text-[#D2552D] hover:bg-gray-50 rounded-r-lg transition-colors duration-300">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <button type="submit" 
                                    class="w-full bg-[#2E5A43] text-white px-6 py-3 rounded-xl hover:bg-[#234434] transform hover:scale-105 transition-all duration-300 flex items-center justify-center space-x-2">
                                <i class="fas fa-cart-plus"></i>
                                <span>Tambah ke Keranjang</span>
                            </button>
                        </form>
                    </div>
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
                                <div class="bg-gray-50 rounded-xl p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Berikan Ulasan Anda</h3>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                                            <div class="flex items-center space-x-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <input type="radio" 
                                                           name="rating" 
                                                           id="rating{{ $i }}" 
                                                           value="{{ $i }}" 
                                                           class="hidden peer" 
                                                           {{ old('rating') == $i ? 'checked' : '' }}>
                                                    <label for="rating{{ $i }}" 
                                                           class="text-2xl cursor-pointer text-gray-300 hover:text-yellow-400 peer-checked:text-yellow-400 transition-colors duration-200">
                                                        <i class="fas fa-star"></i>
                                                    </label>
                                                @endfor
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Komentar</label>
                                            <textarea name="komentar" 
                                                      rows="3" 
                                                      class="w-full rounded-lg border-gray-300 focus:border-[#2E5A43] focus:ring focus:ring-[#2E5A43]/20 transition-shadow duration-200"
                                                      placeholder="Bagikan pengalaman Anda...">{{ old('komentar') }}</textarea>
                                        </div>

                                        <button type="submit"
                                                class="bg-[#2E5A43] text-white px-6 py-2 rounded-lg hover:bg-[#234434] transform hover:scale-105 transition-all duration-300">
                                            Kirim Ulasan
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endauth

                    <div class="space-y-6">
                        @forelse($kuliner->ratings as $rating)
                            <div class="bg-white rounded-lg p-6 animate-fade-in transform hover:-translate-y-1 transition-all duration-300">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <div class="w-12 h-12 rounded-full bg-[#2E5A43] flex items-center justify-center text-white">
                                                <span class="text-lg font-semibold">{{ strtoupper(substr($rating->user->name, 0, 1)) }}</span>
                                            </div>
                                        </div>
                                        <div>
                                            <h4 class="text-lg font-semibold text-gray-900">{{ $rating->user->name }}</h4>
                                            <p class="text-gray-500 text-sm">{{ $rating->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $rating->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                                
                                @if($rating->komentar)
                                    <p class="mt-4 text-gray-600">{{ $rating->komentar }}</p>
                                @endif

                                @if(Auth::id() === $rating->user_id)
                                    <div class="mt-4 flex items-center space-x-4">
                                        <button onclick="editRating({{ $rating->id }})" 
                                                class="text-sm text-gray-500 hover:text-[#2E5A43] transition-colors duration-300">
                                            <i class="fas fa-edit mr-1"></i>
                                            Edit
                                        </button>
                                        <form action="{{ route('rating.destroy', $rating) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus ulasan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-sm text-gray-500 hover:text-red-500 transition-colors duration-300">
                                                <i class="fas fa-trash-alt mr-1"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <i class="fas fa-comment-alt text-4xl text-gray-300 mb-4"></i>
                                <p class="text-gray-500">Belum ada ulasan untuk menu ini</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
    animation: fadeIn 0.5s ease-out forwards;
}
</style>

<script>
function updateQuantity(change) {
    const input = document.getElementById('quantity');
    const newValue = parseInt(input.value) + change;
    const maxStock = parseInt(input.max);
    
    if (newValue >= 1 && newValue <= maxStock) {
        input.value = newValue;
    }
}

function editRating(ratingId) {
    // Implement rating edit functionality
    console.log('Edit rating:', ratingId);
}
</script>
@endsection
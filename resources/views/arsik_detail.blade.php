<!DOCTYPE html>
<html lang="id">

<head>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sejarah Kuliner - Arsik Ikan Mas</title>

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            tobaRed: '#B83232',
            tobaOrange: '#F2935C',
            tobaGreen: '#1C4A45',
            tobaBlue: '#2D6A73',
            tobaCream: '#FDF7F0',
            tobaHighlight: '#EA5A0D',
          },
          fontFamily: {
            sans: ['"Segoe UI"', 'sans-serif'],
          }
        }
      }
    }
  </script>
</head>

<body class="bg-tobaCream text-tobaGreen font-sans">

  <!-- Header -->
  <header class="bg-tobaGreen text-white py-4 shadow-md">
    <div class="container mx-auto px-4 text-center">
      <h1 class="text-2xl font-bold italic">TobaTaste</h1>
    </div>
  </header>

  <!-- Hero -->
  <section class="text-center my-10">
    <h2 class="text-4xl font-extrabold text-tobaHighlight">Sejarah Kuliner - Arsik Ikan Mas</h2>
    <p class="text-2xl font-semibold text-tobaHighlight mt-2">Mengenal kelezatan warisan kuliner tradisional Toba</p>
  </section>

<!-- Konten -->
<section class="container mx-auto px-4 mb-10">
  <div class="bg-[#FFF7ED] rounded-3xl shadow-md p-6 md:flex gap-8 items-center hover:shadow-xl transition-shadow duration-300">
    
    <!-- Gambar -->
    <div class="flex justify-center md:w-1/3">
      <div 
        class="relative overflow-hidden rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 ease-in-out cursor-pointer group"
      >
        <img 
          src="{{ asset('images/mie gomak.jpg') }}" 
          alt="Mie Gomak"
          class="w-full h-auto max-h-80 object-cover rounded-2xl transform transition-transform duration-[6000ms] ease-out group-hover:scale-150"
        />
      </div>
    </div>

    <!-- Deskripsi -->
    <div class="mt-6 md:mt-0 md:flex-1 text-center md:text-left">
      <h3 class="text-3xl font-extrabold text-orange-500 mb-4">🍜 Sejarah Arsik Ikan Mas</h3>
      <p class="text-tobaBlue leading-relaxed text-lg">
        Arsik adalah hidangan khas Batak Toba yang terkenal dengan cita rasa rempah seperti andaliman dan kecombrang. 
        Dahulu disajikan dalam upacara adat sebagai simbol kemakmuran. 🌟
      </p>
    </div>

  </div>
</section>


<!-- Wrapper Section -->
<section class="bg-[#FFF7ED] py-12">
  
  <!-- Resep -->
  <div class="container mx-auto px-4 mb-16">
    <div class="bg-[#FFF7ED] rounded-3xl shadow-md p-8 hover:shadow-xl transition-shadow duration-300">
      <h3 class="text-3xl font-extrabold text-tobaHighlight mb-8">📖 Resep Kuliner</h3>

      <div class="mb-8">
        <h4 class="font-semibold text-tobaHighlight mb-4 text-2xl">🛒 Bahan - Bahan:</h4>
        <ul class="list-disc list-inside space-y-2 text-tobaBlue text-lg">
          <li>2 ekor ikan mas 🐟</li>
          <li>10 buah cabai merah 🌶️</li>
          <li>2 ruas jahe 🫚</li>
          <li>2 batang serai 🌿</li>
          <li>1 sdm andaliman ✨</li>
        </ul>
      </div>

      <div>
        <h4 class="font-semibold text-tobaHighlight mb-4 text-2xl">👨‍🍳 Cara Memasak:</h4>
        <p class="text-tobaBlue text-lg leading-relaxed">
          Haluskan semua bumbu dan tumis hingga harum. Masukkan ikan dan tambahkan air. 
          Masak dengan api sedang hingga matang dan bumbu meresap sempurna! 🍲
        </p>
      </div>

      <!-- Tombol -->
      <div class="flex flex-wrap gap-4 mt-10">
        <a href="http://localhost/kuliner/produk"
          class="bg-tobaGreen text-white px-6 py-3 rounded-full font-semibold hover:bg-[#143932] transition">
          ⬅️ Kembali
        </a>
        <button class="bg-tobaHighlight text-white px-6 py-3 rounded-full font-semibold hover:bg-[#c94b0b] transition">
          🛒 Beli Sekarang
        </button>
        <button
          class="border border-tobaHighlight text-tobaHighlight px-6 py-3 rounded-full font-semibold hover:bg-tobaOrange hover:text-white transition">
          🛍️ Tambah ke Keranjang
        </button>
      </div>
    </div>
  </div>

  <!-- Komentar & Rating -->
  <div class="container mx-auto px-4">
    <div x-data="{ rating: 0, hover: 0, comment: '' }" class="bg-[#FFF7ED] rounded-3xl shadow-md p-8 hover:shadow-xl transition-shadow duration-300">
      <h4 class="text-2xl font-extrabold text-tobaRed mb-8">🌟 Beri Rating dan Komentar</h4>

      <!-- Rating Interaktif -->
      <div class="flex items-center space-x-2 mb-8">
        <template x-for="i in 5">
          <svg @click="rating = i" @mouseover="hover = i" @mouseleave="hover = 0"
            :class="[(hover || rating) >= i ? 'text-yellow-400' : 'text-gray-300']"
            class="w-10 h-10 cursor-pointer transition-transform hover:scale-110" fill="currentColor" viewBox="0 0 20 20">
            <path
              d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.955a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.287 3.955c.3.921-.755 1.688-1.538 1.118l-3.37-2.448a1 1 0 00-1.176 0l-3.37 2.448c-.783.57-1.838-.197-1.538-1.118l1.287-3.955a1 1 0 00-.364-1.118L2.075 9.382c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.955z" />
          </svg>
        </template>
        <span x-text="rating + ' dari 5'" class="ml-4 text-lg text-gray-600"></span>
      </div>

      <!-- Textarea Komentar -->
      <textarea x-model="comment" placeholder="Tulis komentarmu di sini... ✍️"
        class="w-full border border-gray-300 rounded-2xl p-5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-tobaGreen mb-8"
        rows="4"></textarea>

      <!-- Tombol Kirim -->
      <button @click="alert('Rating: ' + rating + '/5\nKomentar: ' + comment)"
        class="bg-tobaGreen text-white px-8 py-3 rounded-full font-bold hover:bg-[#143932] transition">
        🚀 Kirim
      </button>
    </div>
  </div>

</section>


  <!-- Footer -->
  <footer class="bg-tobaGreen text-white text-center py-4 mt-10">
    <p>&copy; 2025 Toba Taste. Warisan Kuliner Nusantara.</p>
  </footer>
  <!-- jangan lupa include AlpineJS -->
<script src="//unpkg.com/alpinejs" defer></script>

</body>

</html>

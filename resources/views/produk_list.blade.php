<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Menu TOBA TASTE</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Swiper CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">


  <style>
    :root {
      --toba-green-dark: #254D3B;
      --toba-green-light: #4B7B5D;
      --toba-orange: #D8532B;
      --toba-cream: #F7F1E5;
      --toba-text-dark: #1C1C1C;
    }

    .bg-toba-cream {
      background-color: var(--toba-cream);
    }

    .text-toba-orange {
      color: var(--toba-orange);
    }

    .bg-toba-orange {
      background-color: var(--toba-orange);
    }

    .text-toba-green-dark {
      color: var(--toba-green-dark);
    }

    .bg-toba-green-dark {
      background-color: var(--toba-green-dark);
    }

    .hover\:text-toba-orange:hover {
      color: var(--toba-orange);
    }

    .menu-card:hover {
      transform: scale(1.03);
      box-shadow: 0 6px 20px rgba(213, 83, 43, 0.4);
    }

    .hover-blur:hover img {
      filter: blur(2px);
      transform: scale(1.05);
      transition: all 0.3s ease;
    }

    .hover-blur:hover .overlay-text {
      opacity: 1;
      transform: translateY(0);
    }

    .overlay-text {
      transition: all 0.3s ease;
      transform: translateY(10px);
      opacity: 0;
    }
  </style>
</head>

<body class="bg-toba-cream text-toba-green-dark transition-opacity duration-700 opacity-0"
  onload="document.body.style.opacity='1'">

  <!-- Navbar -->
  <nav class="bg-[#254D3B] px-8 py-4 flex justify-between items-center shadow-md">
    <div class="flex items-center space-x-10">
      <div class="text-[#F7F1E5] font-bold italic text-2xl">TobaTaste</div>
      <div class="flex space-x-4 text-white text-sm">
        <a href="produk" class="hover:underline px-4 py-2 rounded hover:bg-[#c24623] focus:bg-[#c24623]">Home</a>
        <a href="menu" class="hover:underline px-4 py-2 rounded hover:bg-[#c24623] focus:bg-[#c24623]">Menu</a>
        <a href="about" class="hover:underline px-4 py-2 rounded hover:bg-[#c24623] focus:bg-[#c24623]">About</a>
        <a href="contact" class="hover:underline px-4 py-2 rounded hover:bg-[#c24623] focus:bg-[#c24623]">Contact</a>
      </div>
    </div>
    <div class="flex items-center space-x-4">
      <input type="text" placeholder="Search"
        class="px-4 py-2 rounded bg-[#F7F1E5] text-[#254D3B] text-sm w-40 focus:outline-none">
      <button class="text-2xl text-[#F7F1E5] hover:text-[#D8532B]">🔍</button>
      <button class="text-2xl text-[#F7F1E5] hover:text-[#D8532B]" onclick="window.location.href='card'">🛒</button>
      <button class="text-2xl text-[#F7F1E5] hover:text-[#D8532B]" onclick="window.location.href='profil'">👤</button>
    </div>
  </nav>

  <!-- Hero Banner -->
  <section class="relative h-screen bg-cover bg-center" style="background-image: url('images/danau toba.jpg');">
    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="text-center px-4 max-w-3xl mx-auto">
  <div class="bg-[#F7F1E5]/60 text-tobaGreen p-8 rounded-2xl shadow-2xl border border-gray-300 backdrop-blur-sm">
    <h1 class="text-5xl font-bold mb-4 drop-shadow-lg">
      Selamat Datang di <span class="text-orange-600">TobaTaste</span>
    </h1>
    <p class="text-lg font-medium leading-relaxed">
      Ayo!! Cari kuliner yang Anda sukai. Anda bisa membeli kuliner
      yang diinginkan, dan juga mengetahui resep & sejarahnya.
    </p>
  </div>
</div>
  
    </div>
  </section>

  <section class="py-20 px-6 bg-[#F7F1E5]/60 backdrop-blur-sm">
  <div class="max-w-6xl mx-auto">
    <!-- Judul -->
    <h2 class="text-4xl font-extrabold text-center text-orange-600 mb-14 drop-shadow-md" data-aos="fade-down" data-aos-duration="1000">
      Menu Populer
    </h2>

  <div class="swiper mySwiper">
    <div class="swiper-wrapper">

      <!-- Slide 1 - Arsik Ikan Mas -->
      <div class="swiper-slide">
        <div class="menu-card bg-white rounded-xl overflow-hidden shadow-lg transition-transform duration-300 hover:scale-105 flex flex-col">
          <div class="hover-blur relative">
            <a href="/kuliner/menu/arsik-ikan-mas" class="block">
              <img src="images/arsik.jpg" alt="Arsik Ikan Mas" class="w-full h-60 object-cover">
              <div class="overlay-text absolute inset-0 flex items-center justify-center text-white font-bold text-xl bg-black bg-opacity-40">
                Lihat Detail
              </div>
            </a>
          </div>
          <div class="p-4 text-center flex flex-col justify-between flex-1">
            <div>
              <h3 class="text-xl font-semibold text-toba-green-dark">Arsik Ikan Mas</h3>
              <p class="text-sm text-gray-600 mt-2">Ikan mas khas Batak dengan bumbu andaliman dan rempah lokal.</p>
              <div class="text-yellow-400 mt-2">⭐️⭐️⭐️⭐️☆ (4.5)</div>
            </div>
            <div class="mt-4 flex justify-center gap-2">
              <button class="bg-[#D8532B] text-white px-4 py-2 rounded hover:bg-[#c24623] text-sm">Beli</button>
              <button class="border border-[#D8532B] text-[#D8532B] px-4 py-2 rounded hover:bg-orange-100 text-sm">Masukkan Keranjang</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Slide 2 - Naniura -->
      <div class="swiper-slide">
        <div class="menu-card bg-white rounded-xl overflow-hidden shadow-lg transition-transform duration-300 hover:scale-105 flex flex-col">
          <div class="hover-blur relative">
            <a href="/kuliner/menu/arsik-ikan-mas" class="block">
              <img src="images/naniura.jpg" alt="Arsik Ikan Mas" class="w-full h-60 object-cover">
              <div class="overlay-text absolute inset-0 flex items-center justify-center text-white font-bold text-xl bg-black bg-opacity-40">
                Lihat Detail
              </div>
            </a>
          </div>
          <div class="p-4 text-center flex flex-col justify-between flex-1">
            <div>
              <h3 class="text-xl font-semibold text-toba-green-dark">Naniura</h3>
              <p class="text-sm text-gray-600 mt-2">Ikan mas segar tanpa dimasak, dibumbui andaliman dan jeruk purut.</p>
              <div class="text-yellow-400 mt-2">⭐️⭐️⭐️⭐️☆ (4.5)</div>
            </div>
            <div class="mt-4 flex justify-center gap-2">
              <button class="bg-[#D8532B] text-white px-4 py-2 rounded hover:bg-[#c24623] text-sm">Beli</button>
              <button class="border border-[#D8532B] text-[#D8532B] px-4 py-2 rounded hover:bg-orange-100 text-sm">Masukkan Keranjang</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Slide 3 - Lontong Medan -->
      <div class="swiper-slide">
        <div class="menu-card bg-white rounded-xl overflow-hidden shadow-lg transition-transform duration-300 hover:scale-105 flex flex-col">
          <div class="hover-blur relative">
            <a href="/kuliner/menu/arsik-ikan-mas" class="block">
              <img src="images/lontong.jpg" alt="Arsik Ikan Mas" class="w-full h-60 object-cover">
              <div class="overlay-text absolute inset-0 flex items-center justify-center text-white font-bold text-xl bg-black bg-opacity-40">
                Lihat Detail
              </div>
            </a>
          </div>
          <div class="p-4 text-center flex flex-col justify-between flex-1">
            <div>
              <h3 class="text-xl font-semibold text-toba-green-dark">Lontong Medan</h3>
              <p class="text-sm text-gray-600 mt-2">Daging babi cincang dimasak dengan darah dan bumbu khas Batak.</p>
              <div class="text-yellow-400 mt-2">⭐️⭐️⭐️⭐️☆ (4.5)</div>
            </div>
            <div class="mt-4 flex justify-center gap-2">
              <button class="bg-[#D8532B] text-white px-4 py-2 rounded hover:bg-[#c24623] text-sm">Beli</button>
              <button class="border border-[#D8532B] text-[#D8532B] px-4 py-2 rounded hover:bg-orange-100 text-sm">Masukkan Keranjang</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Slide 4 - Mie Gomak -->
      <div class="swiper-slide">
        <div class="menu-card bg-white rounded-xl overflow-hidden shadow-lg transition-transform duration-300 hover:scale-105 flex flex-col">
          <div class="hover-blur relative">
            <a href="/kuliner/menu/arsik-ikan-mas" class="block">
              <img src="images/mie gomak.jpg" alt="Arsik Ikan Mas" class="w-full h-60 object-cover">
              <div class="overlay-text absolute inset-0 flex items-center justify-center text-white font-bold text-xl bg-black bg-opacity-40">
                Lihat Detail
              </div>
            </a>
          </div>
          <div class="p-4 text-center flex flex-col justify-between flex-1">
            <div>
              <h3 class="text-xl font-semibold text-toba-green-dark">Mie Gomak</h3>
              <p class="text-sm text-gray-600 mt-2">Mie khas Batak, sering disebut "spaghetti Batak" dengan bumbu andaliman.</p>
              <div class="text-yellow-400 mt-2">⭐️⭐️⭐️⭐️☆ (4.5)</div>
            </div>
            <div class="mt-4 flex justify-center gap-2">
              <button class="bg-[#D8532B] text-white px-4 py-2 rounded hover:bg-[#c24623] text-sm">Beli</button>
              <button class="border border-[#D8532B] text-[#D8532B] px-4 py-2 rounded hover:bg-orange-100 text-sm">Masukkan Keranjang</button>
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Navigasi & Pagination -->
    <div class="swiper-pagination mt-6"></div>
    <div class="swiper-button-next text-orange-600"></div>
    <div class="swiper-button-prev text-orange-600"></div>
  </div>
</section>




  <!-- About Us -->
  <section class="py-20 text-center bg-cover bg-opacity-90">
  <div class="max-w-3xl mx-auto px-6 border border-white-300 rounded-2xl shadow-xl p-10">
    <h2 class="text-3xl font-bold mb-6 text-tobaGreen">Tentang Kami</h2>
    <p class="text-gray-700 mb-4 leading-relaxed text-lg">
      Kami memperkenalkan dan melestarikan cita rasa kuliner khas Toba. Setiap hidangan punya cerita dan rasa
      yang unik.
    </p>
    <p class="text-gray-700 leading-relaxed text-lg">
      Dukung UMKM lokal dan eksplorasi kuliner otentik khas Toba.
    </p>
    <div class="mt-10">
      <img 
        src="images/tobataste.png" 
        alt="Logo" 
        class="mx-auto h-40 mb-4 animate-spin-slow" 
      />
      <h3 class="text-2xl font-semibold text-orange-600">Toba Taste</h3>
    </div>
  </div>
</section>

<!-- Tambahkan animasi custom di Tailwind -->
<style>
  @keyframes spin-slow {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
  }

  .animate-spin-slow {
    animation: spin-slow 8s linear infinite;
  }
</style>

  <!-- Kontak Kami -->
  <section class="py-20 text-center bg-[#F7F1E5] bg-opacity-80">
    <h2 class="text-3xl font-bold text-orange-600 mb-6">Kontak Kami</h2>
    <p class="text-gray-700 mb-4 text-lg">Email: <span class="font-semibold">info@tobataste.com</span> | Telp: <span
        class="font-semibold">0812-3456-7890</span></p>
    <div class="flex justify-center space-x-6 text-xl">
      <a href="#" class="text-tobaGreen hover:text-orange-600 transition duration-300">Instagram</a>
      <a href="#" class="text-tobaGreen hover:text-orange-600 transition duration-300">Facebook</a>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-[#4B7B5D] text-white text-center py-6">
    <p class="text-lg">&copy; 2025 <span class="font-bold tracking-wide">TOBATASTE</span>. All rights reserved.</p>
  </footer>

  <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <!-- Swiper CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <!-- Swiper JS (tempel di akhir body) -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script>
    var swiper = new Swiper(".mySwiper", {
      slidesPerView: 1,
      spaceBetween: 20,
      loop: true,
      autoplay: {
        delay: 2500,
        disableOnInteraction: false,
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev"
      },
      breakpoints: {
        640: { slidesPerView: 1 },
        768: { slidesPerView: 2 },
        1024: { slidesPerView: 3 }
      }
    });
  </script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init();
</script>

</body>

</html>
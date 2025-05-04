@extends('layouts.app')

@section('title', 'Tentang Kami - TOBA TASTE')

@section('content')
<!-- Background motif bergerak -->
<div class="batak-pattern animated-background"></div>

<!-- Tentang Kami -->
<section class="relative bg-[#F7F1E5] py-12 text-center z-10">
  <div class="max-w-3xl mx-auto px-6 animate-fadeInUp relative">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">About Us</h2>
    <p class="text-gray-700 leading-relaxed mb-4">
      Selamat datang di Kuliner Khas Toba! Kami adalah tim yang berdedikasi untuk memperkenalkan dan melestarikan keunikan cita rasa kuliner khas Toba.
      Dari Bika Ambon yang lembut dan mempunyai aroma yang sangat menggoda hingga Soto Toba yang kaya rempah, kami percaya setiap hidangan memiliki cerita dan budaya yang layak untuk diketahui dan dinikmati.
    </p>
    <p class="text-gray-700 leading-relaxed mb-4">
      Misi kami adalah menjadi sumber informasi terpercaya tentang makanan khas Toba sekaligus menghubungkan Anda dengan pengalaman kuliner terbaik di kota ini.
      Temukan rekomendasi restoran, resep otentik, dan cerita menarik seputar kuliner Toba di platform kami.
    </p>
    <p class="text-gray-700 leading-relaxed">
      Terima kasih telah bergabung bersama kami dalam merayakan kekayaan kuliner Toba!
    </p>
  </div>

  <!-- Logo di bawah -->
<!-- Logo di bawah -->
<div class="mt-10">
  <img src="{{ asset('images/tobataste.png') }}" alt="Toba Taste Logo" 
    class="mx-auto h-32 opacity-80 mb-6 animate-logo-spin" />
</div>


<style>
@keyframes logoSpin {
  0% { transform: rotate(0deg) scale(1); }
  50% { transform: rotate(180deg) scale(1.1); }
  100% { transform: rotate(360deg) scale(1); }
}

.animate-logo-spin {
  animation: logoSpin 8s linear infinite;
}
</style>

</section>
@endsection

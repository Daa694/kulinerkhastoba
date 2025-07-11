@extends('layouts.app')

@section('title', 'Tentang & Kontak - TOBA TASTE')

@section('content')
<div class="batak-pattern"></div>

<!-- About & Contact Section -->
<section class="bg-[#F7F1E5] py-12">
  <div class="max-w-6xl mx-auto flex flex-col md:flex-row justify-between gap-10">
    <!-- About Section -->
    <div class="md:w-1/2 mb-10 md:mb-0 flex flex-col justify-center">
      <h2 class="text-3xl font-bold mb-4 text-[#D2552D]">Tentang Kami</h2>
      <p class="text-gray-700 leading-relaxed mb-3">
        Selamat datang di Kuliner Khas Toba! Kami adalah tim yang berdedikasi untuk memperkenalkan dan melestarikan keunikan cita rasa kuliner khas Toba.
        Dari Bika Ambon yang lembut dan mempunyai aroma yang sangat menggoda hingga Soto Toba yang kaya rempah, kami percaya setiap hidangan memiliki cerita dan budaya yang layak untuk diketahui dan dinikmati.
      </p>
      <p class="text-gray-700 leading-relaxed mb-3">
        Misi kami adalah menjadi sumber informasi terpercaya tentang makanan khas Toba sekaligus menghubungkan Anda dengan pengalaman kuliner terbaik di kota ini.
        Temukan rekomendasi restoran, resep otentik, dan cerita menarik seputar kuliner Toba di platform kami.
      </p>
      <p class="text-gray-700 leading-relaxed mb-3">
        Terima kasih telah bergabung bersama kami dalam merayakan kekayaan kuliner Toba!
      </p>
      <div class="mt-6">
        <img src="{{ asset('images/tobataste.png') }}" alt="Toba Taste Logo" class="mx-auto h-28 opacity-90 mb-2 animate-logo-spin" />
      </div>
    </div>
    <!-- Contact Section -->
    <div class="md:w-1/2">
      <h2 class="text-3xl font-bold mb-2">Kontak Kami</h2>
      <p class="text-gray-700 mb-6">Kami sangat senang jika Anda mengirimkan pesan ke website kami. Isi formulir di bawah ini untuk menghubungi kami.</p>
      @if(Auth::check() && Auth::user()->isAdmin())
        <div class="flex flex-wrap gap-3 mb-4">
          <a href="{{ route('contact.edit') }}" class="inline-block bg-yellow-400 text-gray-900 px-4 py-2 rounded font-semibold hover:bg-yellow-500">Edit Kontak</a>
          <a href="{{ route('about.edit') }}" class="inline-block bg-yellow-400 text-gray-900 px-4 py-2 rounded font-semibold hover:bg-yellow-500">Edit Tentang Kami</a>
        </div>
      @endif
      @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
          <span class="block sm:inline">{{ session('success') }}</span>
        </div>
      @endif
      @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
          <ul class="list-disc pl-5">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
      <form method="POST" action="{{ route('contact.send') }}" class="bg-white p-6 rounded border space-y-4 shadow mb-6">
        @csrf
        <input type="text" name="name" placeholder="Full Name" class="w-full px-4 py-2 border rounded text-sm focus:outline-none" value="{{ old('name', Auth::check() ? Auth::user()->name : '') }}" @if(Auth::check()) readonly @endif required>
        <input type="email" name="email" placeholder="Email Address" class="w-full px-4 py-2 border rounded text-sm focus:outline-none" value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}" @if(Auth::check()) readonly @endif required>
        <textarea name="message" rows="4" placeholder="Message" class="w-full px-4 py-2 border rounded text-sm focus:outline-none" required>{{ old('message') }}</textarea>
        <button class="bg-[#D8532B] text-white px-4 py-2 rounded hover:bg-gray-800 text-sm">Send Message</button>
      </form>
      <div class="bg-white rounded p-4 shadow text-left">
        <h3 class="text-xl font-semibold mb-2">Info Kontak</h3>
        <p>📍 {{ $contact->alamat ?? 'Alamat belum diisi' }}</p>
        <p>📞 {{ $contact->telepon ?? '-' }}</p>
        <p>✉️ {{ $contact->email ?? '-' }}</p>
        <div class="mt-3">
          <h4 class="text-lg font-semibold mb-1">Follow Us</h4>
          <div class="flex space-x-4 text-2xl">
            @if(!empty($contact->facebook))<a href="{{ $contact->facebook }}" target="_blank">📘</a>@endif
            @if(!empty($contact->instagram))<a href="{{ $contact->instagram }}" target="_blank">📸</a>@endif
            @if(!empty($contact->twitter))<a href="{{ $contact->twitter }}" target="_blank">🐦</a>@endif
            @if(!empty($contact->website))<a href="{{ $contact->website }}" target="_blank">🔗</a>@endif
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

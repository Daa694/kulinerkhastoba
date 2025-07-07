@extends('layouts.app')

@section('title', 'Contact Us - TOBA TASTE')

@section('content')
<div class="batak-pattern"></div>

<!-- Contact Section -->
<section class="bg-[#F7F1E5] py-12 text-center">
  <div class="max-w-6xl mx-auto flex flex-col md:flex-row justify-between gap-10">
    
    <!-- Form Section -->
    <div class="md:w-2/3">
      <h2 class="text-3xl font-bold mb-2">Contact Us</h2>
      <p class="text-gray-700 mb-6">Kami sangat senang jika Anda mengirimkan pesan ke website kami. Isi formulir di bawah ini untuk menghubungi kami.</p>
      @if(Auth::check() && Auth::user()->isAdmin())
        <a href="{{ route('contact.edit') }}" class="inline-block mb-4 bg-yellow-400 text-gray-900 px-4 py-2 rounded font-semibold hover:bg-yellow-500">Edit Kontak</a>
      @endif
      <form class="bg-white p-6 rounded border space-y-4 shadow">
        <input type="text" placeholder="Full Name" class="w-full px-4 py-2 border rounded text-sm focus:outline-none">
        <input type="email" placeholder="Email Address" class="w-full px-4 py-2 border rounded text-sm focus:outline-none">
        <textarea rows="4" placeholder="Message" class="w-full px-4 py-2 border rounded text-sm focus:outline-none"></textarea>
        <button class="bg-[#D8532B] text-white px-4 py-2 rounded hover:bg-gray-800 text-sm">Send Message</button>
      </form>
    </div>

    <!-- Contact Info -->
    <div class="md:w-1/3 text-left space-y-6">
      
      <div>
        <h3 class="text-xl font-semibold mb-2">Get In Touch</h3>
        <p>📍 {{ $contact->alamat ?? 'Alamat belum diisi' }}</p>
        <p>📞 {{ $contact->telepon ?? '-' }}</p>
        <p>✉️ {{ $contact->email ?? '-' }}</p>
      </div>
      <div>
        <h3 class="bg-[#F7F1E5] text-xl font-semibold mb-2">Follow Us</h3>
        <div class="flex space-x-4 text-2xl">
          @if(!empty($contact->facebook))<a href="{{ $contact->facebook }}" target="_blank">📘</a>@endif
          @if(!empty($contact->instagram))<a href="{{ $contact->instagram }}" target="_blank">📸</a>@endif
          @if(!empty($contact->twitter))<a href="{{ $contact->twitter }}" target="_blank">🐦</a>@endif
          @if(!empty($contact->website))<a href="{{ $contact->website }}" target="_blank">🔗</a>@endif
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

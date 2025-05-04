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
        <p>📍 123 Street, Medan, Indomaret</p>
        <p>📞 +62 123 456 789</p>
        <p>✉️ kulinerkhasmedan@gmail.com</p>
      </div>
      <div>
        <h3 class="bg-[#F7F1E5]text-xl font-semibold mb-2">Follow Us</h3>
        
        <div class="flex space-x-4 text-2xl">
          <a href="#">📘</a>
          <a href="#">📸</a>
          <a href="#">🐦</a>
          <a href="#">🔗</a>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

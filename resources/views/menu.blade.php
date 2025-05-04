@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="bg-[#F7F1E5] py-12 text-center">
        <h1 class="text-3xl font-bold text-[#D8532B]">Menu TOBA TASTE</h1>
        <p class="text-[#D8532B] mt-2">Nikmati cita rasa khas Batak dalam setiap gigitan.</p>
    </section>

    <!-- Menu Populer -->
    <section class="py-12 px-6 bg-[#F7F1E5]">
       <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto"> 
            <!-- Menu 1 -->
            <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                <img src="{{ asset('images/lontong.jpg') }}" alt="Lontong" class="w-full h-40 object-cover rounded-t-lg">
                <div class="p-2 text-center">
                    <p class="text-[#D8532B] font-bold">Lontong</p>
                    <p class="text-gray-700">Rp 50.000</p>
                    <div class="mt-2 flex justify-center gap-2">
                        <button class="bg-[#D8532B] text-white px-3 py-1 rounded text-sm hover:bg-[#c24623]">Beli</button>
                        <button class="border border-[#D8532B] text-[#D8532B] px-3 py-1 rounded text-sm hover:bg-orange-100">Detail</button>
                    </div>
                </div>
            </div>

            <!-- Menu 2 -->
            <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                <img src="{{ asset('images/naniura.jpg') }}" alt="Naniura" class="w-full h-40 object-cover rounded-t-lg">
                <div class="p-2 text-center">
                    <p class="text-[#D8532B] font-bold">Ikan Naniura</p>
                    <p class="text-gray-700">Rp 55.000</p>
                    <div class="mt-2 flex justify-center gap-2">
                        <button class="bg-[#D8532B] text-white px-3 py-1 rounded text-sm hover:bg-[#c24623]">Beli</button>
                        <button class="border border-[#D8532B] text-[#D8532B] px-3 py-1 rounded text-sm hover:bg-orange-100">Detail</button>
                    </div>
                </div>
            </div>

            <!-- Menu 3 -->
            <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                <img src="{{ asset('images/mie gomak.jpg') }}" alt="Mie Gomak" class="w-full h-40 object-cover rounded-t-lg">
                <div class="p-2 text-center">
                    <p class="text-[#D8532B] font-bold">Mie Gomak</p>
                    <p class="text-gray-700">Rp 48.000</p>
                    <div class="mt-2 flex justify-center gap-2">
                        <button class="bg-[#D8532B] text-white px-3 py-1 rounded text-sm hover:bg-[#c24623]">Beli</button>
                        <button class="border border-[#D8532B] text-[#D8532B] px-3 py-1 rounded text-sm hover:bg-orange-100">Detail</button>
                    </div>
                </div>
            </div>
        </div>
@endsection

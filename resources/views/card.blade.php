@extends('layouts.app')

@section('content')
<div class="bg-[#f3eaea] p-6 min-h-screen">
  <div class="max-w-6xl mx-auto">
    <h1 class="text-xl font-semibold text-gray-700 mb-4">Riwayat Pesanan</h1>

    <!-- Tabs -->
    <div class="flex space-x-2 mb-4">
      <button class="bg-gray-200 text-sm px-4 py-1 rounded">Cart</button>
    </div>

    <!-- Search -->
    <div class="mb-4">
      <input
        type="text"
        placeholder="Search"
        class="w-full max-w-sm px-3 py-2 border border-gray-300 rounded"
      />
    </div>
    <!-- Hapus & Rating -->
    <div class="mt-4 flex justify-end space-x-2">
      <button class="bg-black text-white text-xs px-3 py-1 rounded">Hapus Pesanan</button>
      <button class="bg-gray-300 text-xs px-3 py-1 rounded">Rating</button>
    </div>
  </div>
</div>
@endsection

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Kuliner</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex min-h-screen bg-[#F6F0E7]">

<!-- Sidebar -->
<aside class="w-64 bg-[#2E5A43] text-white min-h-screen p-5">
  <style>
    @keyframes slow-spin {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }
    .animate-slow-spin {
      animation: slow-spin 10s linear infinite;
    }
  </style>

  <div class="flex flex-col items-center gap-3 mb-10">
    <img src="images/tobataste.png" alt="Toba Taste Logo" 
      class="w-24 h-24 object-contain animate-slow-spin">
  </div>



    <nav class="flex flex-col gap-4">
      <a href="{{ route('dashboard') }}" class="flex items-center gap-2 hover:bg-[#244934] p-2 rounded">
        <span>🏠</span> Dashboard
      </a>
      <a href="{{ route('produk') }}" class="flex items-center gap-2 hover:bg-[#244934] p-2 rounded">
        <span>🍴</span> Detail Menu Kuliner
      </a>
      <a href="#" class="flex items-center gap-2 hover:bg-[#244934] p-2 rounded">
        <span>⭐</span> Rating & Komentar
      </a>
      <a href="#" class="flex items-center gap-2 hover:bg-[#244934] p-2 rounded">
        <span>👥</span> Informasi User
      </a>
      <a href="#" class="flex items-center gap-2 hover:bg-[#244934] p-2 rounded">
        <span>🛒</span> Pembayaran
      </a>
      <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center gap-2 mt-10 hover:bg-[#D2552D] p-2 rounded">
        <span>↩️</span> Logout
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
    </nav>
  </aside>

  <!-- Main Content -->
  <main class="flex-1">

    <!-- Header -->
    <div class="bg-[#2E5A43] text-white p-6">
      <h2 class="text-2xl font-bold text-center">Dashboard Kuliner</h2>
    </div>

    <!-- Main Buttons -->
    <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-6">
      <a href="{{ route('produk') }}" class="bg-[#D2552D] text-white p-6 rounded-lg text-center font-semibold hover:bg-[#244934]">
        🍽️ Menu Kuliner
      </a>
      <a href="#" class="bg-[#D2552D] text-white p-6 rounded-lg text-center font-semibold hover:bg-[#244934]">
        ⭐ Rating & Komentar
      </a>
      <a href="#" class="bg-[#D2552D] text-white p-6 rounded-lg text-center font-semibold hover:bg-[#244934]">
        👥 Informasi User
      </a>
      <a href="#" class="bg-[#D2552D] text-white p-6 rounded-lg text-center font-semibold hover:bg-[#244934]">
        🛒 Data Checkout
      </a>
      <a href="{{ route('contact') }}" class="bg-[#D2552D] text-white p-6 rounded-lg text-center font-semibold hover:bg-[#244934]">
        💬 Contact
      </a>
      <a href="#" class="bg-[#D2552D] text-white p-6 rounded-lg text-center font-semibold hover:bg-[#244934]">
        🛒 Data Keranjang
      </a>
    </div>

    <!-- Table Section -->
    <div class="p-8">
      <table class="min-w-full bg-white border border-gray-200">
        <thead class="bg-[#2E5A43] text-white">
          <tr>
            <th class="p-4 text-left">Nama</th>
            <th class="p-4 text-left">Harga</th>
            <th class="p-4 text-left">Detail</th>
            <th class="p-4 text-left">Rata-rata Rating</th>
            <th class="p-4 text-left">Total Rating</th>
            <th class="p-4 text-left">Aksi</th>
          </tr>
        </thead>
        <tbody class="text-gray-700">
          @foreach($kuliners as $kuliner)
          <tr class="hover:bg-gray-100">
            <td class="p-4">{{ $kuliner->nama }}</td>
            <td class="p-4">{{ $kuliner->harga }}</td>
            <td class="p-4">{{ $kuliner->detail }}</td>
            <td class="p-4">{{ $kuliner->avg_rating ?? '-' }}</td>
            <td class="p-4">{{ $kuliner->total_rating ?? 0 }}</td>
            <td class="p-4">
              <a href="{{ route('kuliner.edit', $kuliner->id) }}" class="text-blue-500 hover:underline">Edit</a>
              <form action="{{ route('kuliner.destroy', $kuliner->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:underline">Hapus</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <a href="{{ route('kuliner.create') }}" class="mt-4 inline-block bg-[#D2552D] text-white p-3 rounded-lg text-center font-semibold hover:bg-[#244934]">
        Tambah Kuliner
      </a>
    </div>

  </main>

</body>
</html>

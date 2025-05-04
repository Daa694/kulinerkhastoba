<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Anda</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<!-- Pakai background gambar -->
<body class="min-h-screen p-6 bg-cover bg-center" style="background-image: url('{{ asset('storage/9ea7f016-7db2-43d6-a418-2162830a7d1b.png') }}');">

    <!-- Container semua konten -->
    <div class="max-w-6xl mx-auto space-y-8">

        <!-- Profil Section -->
        <div class="bg-white/80 p-6 rounded-lg shadow-md">

            <!-- Header Profile -->
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-3xl font-bold flex items-center">
                    <img src="{{ asset('storage/d0a4905a-c0e4-4f34-9c80-70a85ec89cde.png') }}" alt="Profile" class="w-8 h-8 mr-2">
                    Profil Anda
                </h1>
                <div class="flex space-x-2">
                    <!-- Back Button -->
                    <a href="produk" class="flex items-center px-4 py-2 border rounded-lg bg-white text-gray-600 hover:bg-gray-100">
                        <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a8 8 0 100 16 8 8 0 000-16zM5 10l5-5v10l-5-5z" />
                        </svg>
                        Kembali
                    </a>

                    <!-- Logout Button -->
                    <a href="login" class="flex items-center px-4 py-2 border border-red-500 text-red-500 rounded-lg hover:bg-red-100">
                        <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M16 17v-1a4 4 0 00-8 0v1M12 3a9 9 0 019 9v4a3 3 0 01-3 3H6a3 3 0 01-3-3v-4a9 9 0 019-9z" />
                        </svg>
                        Logout
                    </a>
                </div>
            </div>

            <!-- Info Profile -->
            <div class="bg-gray-50 p-6 rounded-md">
                <p><strong>Nama:</strong> Fhrada Samuel Tambunan</p>
                <p><strong>Email:</strong> samuel@gmail.com</p>
                <p><strong>Terdaftar Sejak:</strong> 22 Mar 2025</p>
            </div>

        </div>

        <!-- Keranjang Aktif -->
        <div class="bg-white/80 p-6 rounded-lg shadow-md">

            <h2 class="text-2xl font-semibold flex items-center mb-4">
                <img src="{{ asset('storage/4fd98995-2ae6-4c65-80d9-0c4aaecf02b7.png') }}" alt="Cart" class="w-7 h-7 mr-2">
                Keranjang Aktif
            </h2>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm">
                            <th class="p-3"><input type="checkbox"></th>
                            <th class="p-3 text-left">Nama Kuliner</th>
                            <th class="p-3 text-left">Harga</th>
                            <th class="p-3 text-left">Jumlah</th>
                            <th class="p-3 text-left">Total</th>
                            <th class="p-3 text-left">Alamat</th>
                            <th class="p-3 text-left">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b">
                            <td class="p-3"><input type="checkbox"></td>
                            <td class="p-3">Ikan Mas Arsik</td>
                            <td class="p-3">Rp 55.555</td>
                            <td class="p-3">1</td>
                            <td class="p-3">Rp 55.555</td>
                            <td class="p-3">Pemda 1</td>
                            <td class="p-3">25 Apr 2025, 14:26</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <button class="mt-4 bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg flex items-center">
                🗑️ Hapus yang Dipilih
            </button>

        </div>

        <!-- Riwayat Pesanan -->
        <div class="bg-white/80 p-6 rounded-lg shadow-md">

            <h2 class="text-2xl font-semibold flex items-center mb-4">
                <img src="{{ asset('storage/4205b22e-0881-4577-95e6-f5d9d6ea3e58.png') }}" alt="History" class="w-7 h-7 mr-2">
                Riwayat Pesanan
            </h2>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr class="bg-gray-700 text-white uppercase text-sm">
                            <th class="p-3"><input type="checkbox"></th>
                            <th class="p-3 text-left">Nama Kuliner</th>
                            <th class="p-3 text-left">Harga</th>
                            <th class="p-3 text-left">Jumlah</th>
                            <th class="p-3 text-left">Total</th>
                            <th class="p-3 text-left">Alamat</th>
                            <th class="p-3 text-left">Metode</th>
                            <th class="p-3 text-left">Tanggal</th>
                            <th class="p-3 text-left">Bukti Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b">
                            <td class="p-3"><input type="checkbox"></td>
                            <td class="p-3">Ikan Mas Arsik</td>
                            <td class="p-3">Rp 55.555</td>
                            <td class="p-3">2</td>
                            <td class="p-3 text-green-500 font-semibold">Rp 111.110</td>
                            <td class="p-3">gdfsd</td>
                            <td class="p-3">
                                <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded-full">COD</span>
                            </td>
                            <td class="p-3">24 Apr 2025, 19:33</td>
                            <td class="p-3">Belum ada</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <button class="mt-4 bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg flex items-center">
                🗑️ Hapus yang Dipilih
            </button>

        </div>

    </div>

</body>
</html>

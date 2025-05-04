<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOBA TASTE</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
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
        <input type="text" placeholder="Search" class="px-4 py-2 rounded bg-[#F7F1E5] text-[#254D3B] text-sm w-40 focus:outline-none">
        <button class="text-2xl text-[#F7F1E5] hover:text-[#D8532B]">🔍</button>
        <button class="text-2xl text-[#F7F1E5] hover:text-[#D8532B]" onclick="window.location.href='/card'">🛒</button>
        <button class="text-2xl text-[#F7F1E5] hover:text-[#D8532B]" onclick="window.location.href='/login'">👤</button>
    </div>
</nav>




    <!-- Konten -->
    <main class="min-h-screen">
    <section class="py-12 px-6 bg-[#F7F1E5]">
        @yield('content')
    </main>

  <!-- Footer -->
<footer class="bg-[#4B7B5D] text-white text-center py-4">
  <p>&copy; 2025 TOBA TASTE. All rights reserved.</p>
</footer>
</body>
</html>

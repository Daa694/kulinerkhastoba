<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TOBA TASTE | @yield('title')</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    body {
      background: url('{{ asset('storage/corak-batak.jpg') }}') no-repeat center center;
      background-size: cover;
      background-attachment: fixed;
    }

  @keyframes spin-slow {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
  }

  .animate-spin-slow {
    animation: spin-slow 8s linear infinite;
  }


  </style>
</head>
<body class="min-h-screen flex items-center justify-center">
  <div class="w-full max-w-md p-8 space-y-6 bg-white/90 backdrop-blur-md rounded-lg shadow-lg">
  <div class="flex justify-center">
  <img src="{{ asset('images/tobataste.png') }}" alt="Toba Taste Logo" class="w-20 mb-4 animate-spin-slow">
</div>


    @if(session('success'))
      <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
        {{ session('success') }}
      </div>
    @endif

    @if($errors->any())
      <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
        <ul class="list-disc list-inside">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @yield('content')
  </div>
</body>
</html>

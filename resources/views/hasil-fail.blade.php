<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Gagal</title>
   <script src="https://cdn.tailwindcss.com"></script><meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-[#1e50aa] flex items-center justify-center min-h-screen">
    <div class="bg-white text-center p-6 rounded-md shadow-md w-[320px]">
    <!-- Gambar tanda silang -->
    <img src="{{ asset('img/dash.png') }}" alt="Gagal" class="mx-auto mb-4 w-12 h-12">

    <h2 class="text-xl font-bold mb-2">ABSENSI GAGAL</h2>
    <p class="text-sm text-gray-700 mb-6">
        Absensi gagal, silahkan coba lagi!
    </p>
    <a href="{{ route('face') }}" class="block w-full bg-[#1e50aa] text-white py-2 rounded-md font-semibold hover:bg-[#17418a] transition">
        Coba Lagi
    </a>
</div>
</body>
</html>

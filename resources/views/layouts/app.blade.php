<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - @yield('title', 'Dashboard')</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100 font-sans">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md border-r p-6" x-data="{ openMaster: false }">
            <div class="mb-6">
                <img src="/img/logo-idcloudhost.png" alt="Logo" class="h-10 mx-auto">
            </div>

            <nav class="space-y-4 text-sm font-medium">
                <a href="{{ route('admin.dashboard') }}" class="block text-gray-800 hover:text-blue-600">Dashboard</a>

                <!-- Master Data Collapsible -->
                <div>
                    <button @click="openMaster = !openMaster" class="w-full text-left text-gray-800 hover:text-blue-600 focus:outline-none">
                        Master Data
                    </button>
                    <div x-show="openMaster" x-cloak class="ml-4 mt-2 space-y-1">
                        <a href="{{ route('admin.karyawan') }}" class="block text-gray-600 hover:text-blue-600">Data Karyawan</a>
                        <a href="{{ route('admin.jabatan.index') }}" class="block text-gray-600 hover:text-blue-600">Data Jabatan</a>
                        <a href="{{ route('admin.karyawan.batch-face') }}" class="block text-gray-600 hover:text-blue-600">Generate Wajah Massal</a>
                    </div>
                </div>

                <a href="{{ route('admin.absensi') }}" class="block text-gray-800 hover:text-blue-600">Data Absensi</a>
                <a href="{{ route('admin.lokasi') }}" class="block text-gray-800 hover:text-blue-600">Pengaturan Lokasi</a>
                <a href="{{ route('logout') }}" class="block text-red-600 hover:underline">Keluar</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

</body>
</html>

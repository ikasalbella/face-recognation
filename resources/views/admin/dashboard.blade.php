@extends('layouts.app')

@section('content')

    <!-- Header -->
    <div class="flex justify-between items-center bg-gray-200 px-6 py-4 mb-8 rounded">
        <h1 class="text-lg font-bold">DASHBOARD ADMIN, {{ auth()->user()->name }}!</h1>
        <a href="/logout" class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-900">KELUAR</a>
    </div>

    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gray-200 p-4 rounded">
            <h2 class="font-bold mb-2">Hadir Hari Ini</h2>
            <p class="text-2xl">{{ $hadirHariIni }}</p>
        </div>
        <div class="bg-gray-200 p-4 rounded">
            <h2 class="font-bold mb-2">Berhasil Absensi</h2>
            <p class="text-2xl">{{ $jumlahBerhasil }}</p>
        </div>
    </div>
@endsection

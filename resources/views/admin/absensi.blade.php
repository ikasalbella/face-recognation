@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-100">

    <main class="flex-1 p-8">
        <div class="flex justify-between items-center bg-gray-200 px-6 py-4 mb-8 rounded">
            <h1 class="text-lg font-bold">DATA ABSENSI</h1>
            <a href="{{ route('admin.dashboard') }}" class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-900">KEMBALI</a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border rounded">
                <thead class="bg-gray-200 text-gray-700 text-left">
                    <tr>
                        <th class="p-3 border-b">Nama</th>
                        <th class="p-3 border-b">Waktu</th>
                        <th class="p-3 border-b">Lokasi</th>
                        <th class="p-3 border-b">Status</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800 text-sm">
                    @forelse ($absensi as $absen)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3">{{ optional($absen->user)->name ?? '-' }}</td>

                            <td class="p-3">{{ \Carbon\Carbon::parse($absen->waktu)->format('d-m-Y H:i') }}</td>
                            <td class="p-3">{{ $absen->lokasi ?? '-' }}</td>
                            <td class="p-3">
                                <span class="px-2 py-1 rounded font-semibold
                                    {{ $absen->status === 'berhasil' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($absen->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-3 text-center text-gray-500">Belum ada data absensi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</div>
@endsection

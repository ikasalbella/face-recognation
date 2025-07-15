@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Pengaturan Lokasi</h1>

        {{-- Tombol toggle aktif/nonaktif --}}
        <form action="{{ route('admin.lokasi.toggle') }}" method="POST" class="mb-6">
            @csrf
            <div class="flex items-center justify-between bg-gray-100 p-4 rounded-lg">
                <div>
                    <h2 class="text-lg font-semibold text-gray-700">
                        {{ $lokasi->nama_lokasi ?? 'Lokasi Kantor' }}
                    </h2>
                    <p class="text-sm text-gray-600">
                        {{ $lokasi->alamat ?? 'Alamat belum diatur' }}
                    </p>
                    <p class="text-xs text-gray-500 mt-1">
                        Koordinat: {{ $lokasi->latitude ?? '-' }}, {{ $lokasi->longitude ?? '-' }}
                    </p>
                </div>

                <div>
                    <button type="submit" name="toggle" value="1"
    class="px-4 py-2 rounded-lg font-semibold
    {{ optional($lokasi)->aktif ? 'bg-green-600 text-white' : 'bg-red-400 text-white' }}">
    {{ optional($lokasi)->aktif ? 'ON (Aktif)' : 'OFF (Nonaktif)' }}
</button>
                </div>
            </div>
        </form>

        {{-- Form update lokasi --}}
        <form action="{{ route('admin.lokasi.update') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="nama_lokasi" class="block text-sm font-medium text-gray-700">Nama Lokasi</label>
                <input type="text" name="nama_lokasi" id="nama_lokasi"
                    value="{{ old('nama_lokasi', $lokasi->nama_lokasi ?? '') }}"
                    class="mt-1 block w-full rounded border-gray-300">
            </div>

            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                <input type="text" name="alamat" id="alamat"
                    value="{{ old('alamat', $lokasi->alamat ?? '') }}"
                    class="mt-1 block w-full rounded border-gray-300" placeholder="Jl. Sudirman No.123">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
                    <input type="text" name="latitude" id="latitude"
                        value="{{ old('latitude', $lokasi->latitude ?? '') }}"
                        class="mt-1 block w-full rounded border-gray-300" placeholder="Latitude">
                </div>
                <div>
                    <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
                    <input type="text" name="longitude" id="longitude"
                        value="{{ old('longitude', $lokasi->longitude ?? '') }}"
                        class="mt-1 block w-full rounded border-gray-300" placeholder="Longitude">
                </div>
            </div>

            {{-- Checkbox status aktif --}}
            <div class="flex items-center mt-2">
              <input type="checkbox" name="aktif" id="aktif"
    {{ old('aktif', $lokasi->aktif ?? false) ? 'checked' : '' }}>
<label for="aktif" class="ml-2 text-sm text-gray-700">Aktifkan Lokasi</label>

            </div>

            <div class="mt-4">
                <button type="button" onclick="getLocation()"
                    class="px-4 py-2 bg-blue-500 text-white rounded shadow hover:bg-blue-600 transition">
                    Ambil Lokasi Saya
                </button>

                <button type="submit"
                    class="ml-2 px-4 py-2 bg-green-600 text-white rounded shadow hover:bg-green-700 transition">
                    Simpan Lokasi
                </button>
            </div>
        </form>

        <p class="mt-4 text-xs text-gray-500">* Jika mode aktif, user hanya bisa absen di lokasi kantor.</p>
    </div>
</div>

{{-- Geolocation Script --}}
<script>
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        alert("Geolocation tidak didukung di browser ini.");
    }
}

function showPosition(position) {
    document.getElementById("latitude").value = position.coords.latitude;
    document.getElementById("longitude").value = position.coords.longitude;
}

function showError(error) {
    alert("Gagal mendapatkan lokasi: " + error.message);
}
</script>
@endsection

@extends('layouts.app')
@section('title', 'Edit Data Karyawan')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Edit Data Karyawan</h2>

    <form action="{{ route('admin.karyawan.update', $karyawan->id) }}" method="POST" enctype="multipart/form-data">
@csrf
        @method('PUT')

        <div class="mb-4">
            <label for="nip" class="block text-sm font-medium text-gray-700">NIP</label>
            <input type="text" name="nip" id="nip" class="w-full border rounded p-2" value="{{ old('nip', $karyawan->nip) }}">
        </div>

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
            <input type="text" name="name" id="name" class="w-full border rounded p-2" value="{{ old('name', $karyawan->name) }}">
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" class="w-full border rounded p-2" value="{{ old('email', $karyawan->email) }}">
        </div>

        <div class="mb-4">
            <label for="jabatan" class="block text-sm font-medium text-gray-700">Jabatan</label>
            <input type="text" name="jabatan" id="jabatan" class="w-full border rounded p-2" value="{{ old('jabatan', $karyawan->jabatan) }}">
        </div>

        <div class="mb-4">
            <label for="foto_wajah" class="block text-sm font-medium text-gray-700">Foto Wajah</label>
            <input type="file" name="foto_wajah" id="foto_wajah" accept="image/*" class="w-full border rounded p-2">

            @if ($karyawan->foto_wajah)
                <div class="mt-2">
                    <p class="text-sm text-gray-600">Foto saat ini:</p>
                    <img src="{{ asset('storage/' . $user->foto_wajah) }}" alt="Foto Wajah" class="w-24 h-24 rounded-full object-cover">
                </div>
            @endif
        </div>

        <div class="flex justify-end">
            <a href="{{ route('admin.karyawan') }}" class="mr-2 bg-gray-200 px-4 py-2 rounded">Batal</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection

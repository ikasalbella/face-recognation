@extends('layouts.app')

@section('content')
<div class="p-6 max-w-md mx-auto">
    <h1 class="text-2xl font-bold mb-4">Tambah Jabatan</h1>
    <form action="{{ route('admin.jabatan.store') }}" method="POST">
        @csrf
        <label class="block mb-2">Nama Jabatan</label>
        <input type="text" name="nama" required class="w-full border p-2 rounded mb-4">
        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
    </form>
</div>
@endsection

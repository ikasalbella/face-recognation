@extends('layouts.app')

@section('content')
<div class="p-6 max-w-md mx-auto">
    <h1 class="text-2xl font-bold mb-4">Edit Jabatan</h1>
    <form action="{{ route('admin.jabatan.update', $jabatan->id) }}" method="POST">
        @csrf @method('PUT')
        <label class="block mb-2">Nama Jabatan</label>
        <input type="text" name="nama" value="{{ $jabatan->nama }}" required class="w-full border p-2 rounded mb-4">
        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
    </form>
</div>
@endsection

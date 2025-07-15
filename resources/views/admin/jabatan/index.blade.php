@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Data Jabatan</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-3">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="p-3">#</th>
                <th class="p-3">Nama Jabatan</th>
                <th class="p-3">Nama User</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr class="border-t">
                <td class="p-3">{{ $loop->iteration }}</td>
                <td class="p-3">{{ $user->jabatan }}</td>
                <td class="p-3">{{ $user->name }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="p-3 text-center text-gray-500">Belum ada data jabatan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

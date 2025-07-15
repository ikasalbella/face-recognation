@extends('layouts.app')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Data Karyawan</h2>

        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="p-2">No</th>
                    <th class="p-2">Foto</th>
                    <th class="p-2">Nama</th>
                    <th class="p-2">NIP</th>
                    <th class="p-2">Email</th>
                    <th class="p-2">Password</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($karyawan as $user)
                    <tr class="border-b">
                        {{-- Nomor urut --}}
                        <td class="p-2">{{ $loop->iteration }}</td>

                        {{-- Foto --}}
                        <td class="p-2">
                            @if ($user->foto_wajah)
        <img src="{{ asset('storage/' . $user->foto_wajah) }}" alt="Foto" width="50" height="50" class="rounded-full object-cover" />
    @else
        <span class="text-gray-500 italic">Belum ada</span>
    @endif
                        </td>

                        {{-- Nama --}}
                        <td class="p-2">{{ $user->name }}</td>

                        {{-- NIP --}}
                        <td class="p-2">{{ $user->nip ?? '-' }}</td>

                        {{-- Email --}}
                        <td class="p-2">{{ $user->email }}</td>

                        {{-- Password (disembunyikan) --}}
                        <td class="p-2">********</td>

                        {{-- Aksi --}}
                        <td class="p-2">
                            <a href="{{ route('admin.karyawan.edit', $user->id) }}" class="text-blue-500 hover:underline">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = User::all();
        return view('admin.karyawan.data-karyawan', compact('karyawan'));
    }

    public function edit($id)
    {
        $karyawan = User::findOrFail($id);
        return view('admin.karyawan.edit-karyawan', compact('karyawan'));
    }

    public function update(Request $request, $id)
    {
        $karyawan = User::findOrFail($id);

        $karyawan->update($request->all());

        return redirect()->route('admin.karyawan.index')->with('success', 'Data berhasil diupdate!');
    }

    // Tambahan opsional jika kamu perlu
    public function create()
    {
        return view('admin.karyawan.create-karyawan');
    }

    public function store(Request $request)
    {
        User::create($request->all());

        return redirect()->route('admin.karyawan.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $karyawan = User::findOrFail($id);
        $karyawan->delete();

        return redirect()->route('admin.karyawan.index')->with('success', 'Data berhasil dihapus!');
    }
}

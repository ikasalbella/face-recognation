<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class FaceRegisterController extends Controller
{
    public function show($id)
{
    $user = User::findOrFail($id);
    return view('admin.karyawan.face-register', compact('user'));
}

public function store(Request $request, $id)
{
    $user = User::findOrFail($id);
    $user->face_descriptor = $request->input('descriptor');
    $user->save();

    return redirect()->route('admin.karyawan')->with('success', 'Wajah berhasil didaftarkan!');
}
public function generateFromFoto()
{
    $users = User::whereNotNull('nip')->get();

    return view('admin.karyawan.batch-face', compact('users'));
}
public function batchRegister()
{
    $users = \App\Models\User::whereNotNull('nip')->get(); // atau kondisi lain
    return view('admin.karyawan.batch-face', compact('users'));
}

}

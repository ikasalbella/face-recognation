<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Lokasi;
use App\Models\Karyawan;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;



class AdminController extends Controller
{
    // Dashboard Admin
    public function dashboard()
    {
        $hariIni = Carbon::now()->toDateString();
        $hadirHariIni = Absensi::whereDate('waktu', $hariIni)->count();
        $jumlahBerhasil = Absensi::where('status', 'berhasil')->count();

        return view('dashboard', compact('hadirHariIni', 'jumlahBerhasil'));
    }

    // Menampilkan data absensi
    public function absensi()
    {
        $absensi = Absensi::with('user')->orderBy('waktu', 'desc')->get();
        return view('admin.absensi', compact('absensi'));
    }

    // Menampilkan form pengaturan lokasi
    public function lokasi()
    {
         $lokasi = Lokasi::first() ?? new Lokasi(); // <--- ini kuncinya
    return view('admin.lokasi', compact('lokasi'));
    }

    // Menyimpan pengaturan lokasi
    public function updateLokasi(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'alamat'    => 'required|string',
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $lokasi = Lokasi::first() ?? new Lokasi();

        $lokasi->nama_lokasi = $request->nama_lokasi;
        $lokasi->alamat = $request->alamat;
        $lokasi->latitude = $request->latitude;
        $lokasi->longitude = $request->longitude;
        $lokasi->aktif = $request->has('is_active');
        $lokasi->save();

        return redirect()->route('admin.lokasi')->with('success', 'Pengaturan lokasi berhasil diperbarui.');
    }

    public function index()
{
    $hariIni = Carbon::now()->toDateString();

    $hadirHariIni = Absensi::whereDate('created_at', $hariIni)->count(); // GANTI dari 'waktu' kalau emang pakai created_at
    $jumlahBerhasil = Absensi::where('status', 'berhasil')->count();

    return view('admin.dashboard', compact('hadirHariIni', 'jumlahBerhasil'));
}

public function toggleLokasi()
{
    $lokasi = Lokasi::first();
    $lokasi->aktif = !$lokasi->aktif; // ganti dari is_active
    $lokasi->save();

    return redirect()->route('admin.lokasi')->with('success', 'Status lokasi berhasil diperbarui.');
}

public function karyawan()
{
    $karyawan = User::where('role', 'user')->get(); // Ambil data user role karyawan
    return view('admin.karyawan.data-karyawan', compact('karyawan'));
}


public function jabatan()
{
    $jabatanUnik = User::select('jabatan')
        ->whereNotNull('jabatan')
        ->distinct()
        ->pluck('jabatan');

    return view('admin.jabatan.index', compact('jabatanUnik'));
}

public function edit($id)
{
    $user = User::findOrFail($id);
    return view('admin.karyawan.edit', compact('user'));
}
public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $data = $request->validate([
        'nip' => 'nullable|string',
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email,' . $id,
        'jabatan' => 'nullable|string',
        'shift' => 'nullable|string',
        'foto_wajah' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    if ($request->hasFile('foto_wajah')) {
        // Hapus foto lama jika ada
        if ($user->foto_wajah && Storage::exists('public/' . $user->foto_wajah)) {
            Storage::delete('public/' . $user->foto_wajah);
        }
        $data['foto_wajah'] = $request->file('foto_wajah')->store('wajah', 'public');
    }

    $user->update($data);

    return redirect()->route('admin.karyawan')->with('success', 'Data berhasil diperbarui.');
}
public function dataKaryawan()
{
    $karyawan = User::all(); // atau bisa difilter
    return view('admin.karyawan.data-karyawan', compact('karyawan'));
}
public function editKaryawan($id)
{
    $karyawan = User::findOrFail($id);
    return view('admin.karyawan.edit', compact('karyawan'));
}
public function updateKaryawan(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'nip' => 'nullable|string|max:100',
        'email' => 'required|email',
        'jabatan' => 'nullable|string',
        'foto_wajah' => 'nullable|image|max:2048',
    ]);

    $karyawan = User::findOrFail($id);
    $karyawan->name = $request->name;
    $karyawan->nip = $request->nip;
    $karyawan->email = $request->email;
    $karyawan->jabatan = $request->jabatan;
    // Cek kalau ada upload foto baru
    if ($request->hasFile('foto_wajah')) {
        $foto = $request->file('foto_wajah')->store('wajah', 'public');
        $karyawan->foto_wajah = $foto;
    }

    $karyawan->save();

    return redirect()->route('admin.karyawan')->with('success', 'Data karyawan berhasil diperbarui!');
}
}

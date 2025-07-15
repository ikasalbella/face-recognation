<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lokasi;

class LokasiController extends Controller
{
    // Menampilkan halaman pengaturan lokasi
    public function index()
    {
        $lokasi = Lokasi::first();
        return view('lokasi', compact('lokasi'));
    }

    // Toggle status aktif lokasi
    public function toggleAktif(Request $request)
    {
        $lokasi = Lokasi::first();
        if ($lokasi) {
            $lokasi->aktif = !$lokasi->aktif;
            $lokasi->save();
        }

        return redirect()->route('admin.lokasi')->with('success', 'Status lokasi berhasil diperbarui.');
    }
}
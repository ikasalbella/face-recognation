<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    public function index()
    {
        // Ambil semua data absensi beserta nama user
        $absensis = Absensi::with('user')->orderBy('waktu', 'desc')->get();

        return view('admin.absensi', compact('absensis'));
    }
}

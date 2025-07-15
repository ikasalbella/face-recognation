<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller; // penting!
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Absensi;

class FaceController extends Controller
{
    // ✅ Halaman kamera absensi
    public function index(Request $request)
    {
        if (!Auth::user()->face_descriptor) {
            return redirect()->route('face.register')
                ->with('error', 'Silakan daftarkan wajah terlebih dahulu.');
        }

        $mode = $request->query('mode', 'absen');

        return view('face', [
            'mode' => $mode,
            'faceDescriptor' => Auth::user()->face_descriptor
        ]);
    }

    // ✅ Simpan hasil absensi
    public function store(Request $request)
    {
        $request->validate([
            'descriptor' => 'required|string'
        ]);

        $inputDescriptor = json_decode($request->input('descriptor'));
        $user = Auth::user();
        $savedDescriptor = json_decode($user->face_descriptor);

        if (!$savedDescriptor || !$inputDescriptor) {
            Log::warning('Descriptor tidak lengkap');
            return redirect()->route('absen.fail');
        }

        $distance = $this->euclideanDistance($inputDescriptor, $savedDescriptor);
        $status = $distance < 0.5 ? 'berhasil' : 'gagal';

        Absensi::create([
            'user_id' => $user->id,
            'status' => $status,
            'waktu' => now(),
        ]);

        return redirect()->route($status === 'berhasil' ? 'absen.success' : 'absen.fail');
    }

    // ✅ Simpan descriptor wajah saat registrasi mandiri
    public function registerFace(Request $request)
    {
        $request->validate([
            'descriptor' => 'required|string'
        ]);

        $user = Auth::user();
        $user->face_descriptor = $request->input('descriptor');
        $user->save();

        return redirect()->route('face');
    }

    // ✅ Hitung jarak euclidean antar descriptor
    private function euclideanDistance($a, $b)
    {
        $sum = 0;
        for ($i = 0; $i < count($a); $i++) {
            $sum += pow($a[$i] - $b[$i], 2);
        }
        return sqrt($sum);
    }

    // ✅ Simpan descriptor via form
    public function storeRegisterFace(Request $request)
    {
        $request->validate([
            'descriptor' => 'required|string',
        ]);

        $user = Auth::user();
        $user->face_descriptor = $request->descriptor;
        $user->save();

        return redirect()->route('face')->with('success', 'Wajah berhasil didaftarkan!');
    }

    // ✅ Tampilkan form pendaftaran wajah
    public function showRegisterForm()
    {
        $user = auth()->user();
        return view('face-register', compact('user'));
    }

    // ✅ Simpan descriptor dari form pendaftaran
    public function registerStore(Request $request)
    {
        $request->validate([
            'descriptor' => 'required|string',
        ]);

        $user = Auth::user();
        $user->face_descriptor = $request->input('descriptor');
        $user->save();

        return redirect()->route('face')->with('success', 'Wajah berhasil didaftarkan!');
    }

    // ✅ Simpan descriptor + foto (via admin)
    public function storeRegisterFaceByAdmin(Request $request, $id)
    {
        $request->validate([
            'descriptor' => 'required',
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = User::findOrFail($id);
        $fotoPath = $request->file('foto')->store('public/wajah');
        $fotoFileName = basename($fotoPath);

        $user->face_descriptor = $request->input('descriptor');
        $user->foto_wajah = $fotoFileName;
        $user->save();

        return redirect()->route('admin.karyawan')->with('success', 'Wajah berhasil disimpan');
    }

    // ✅ Simpan snapshot webcam sebagai foto wajah (dipanggil via JS)
    public function save(Request $request)
    {
        $user = auth()->user();
        $imgData = $request->input('image');

        if (preg_match('/^data:image\/(\w+);base64,/', $imgData, $type)) {
            $imgData = substr($imgData, strpos($imgData, ',') + 1);
            $type = strtolower($type[1]);

            $imgData = base64_decode($imgData);
            $filename = uniqid() . '.' . $type;
            $path = public_path('faces/' . $filename);

            if (!file_exists(public_path('faces'))) {
                mkdir(public_path('faces'), 0755, true);
            }

            file_put_contents($path, $imgData);

            $user->foto = $filename;
            $user->save();

            return response()->json([
                'message' => 'Wajah berhasil disimpan!',
                'redirect' => route('dashboard') // bisa ganti ke route('face')
            ]);
        }

        return response()->json(['message' => 'Format gambar tidak valid'], 400);
    }
}

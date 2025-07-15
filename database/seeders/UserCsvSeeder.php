<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserCsvSeeder extends Seeder
{
    public function run(): void
    {
        $path = storage_path('app/dataset(2).csv');
        if (!file_exists($path)) {
            echo "❌ File dataset.csv tidak ditemukan di storage/app\n";
            return;
        }

        $data = array_map('str_getcsv', file($path));
        $headers = array_map('strtolower', str_replace(' ', '_', $data[0])); // Baris pertama = header
        unset($data[0]); // Hapus header

        foreach ($data as $row) {
            $rowData = array_combine($headers, $row);

            User::create([
                'name'           => $rowData['nama'] ?? null,
                'nip'            => $rowData['nip'] ?? null,
                'email'          => $rowData['email'] ?? null,
                'password'       => Hash::make($rowData['password'] ?? 'default123'), // password wajib di-hash
                'nomor_hp'       => $rowData['nomor_hp'] ?? null,
                'alamat'         => $rowData['alamat'] ?? null,
                'jabatan'        => $rowData['jabatan'] ?? null,
                'tempat_lahir'   => $rowData['tempat_lahir'] ?? null,
                'role'           => 'user',
            ]);
        }

        echo "✅ Data berhasil diimport dari dataset.csv!\n";
    }
}

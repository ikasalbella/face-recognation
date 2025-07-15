<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new User([
            'nip'        => $row['nip'],
            'name'       => $row['name'],
            'email'      => $row['email'],
            'jabatan'    => $row['jabatan'],
            'shift'      => $row['shift'],
            'password'   => Hash::make($row['password']),
            'foto_wajah' => $row['foto_wajah'] ? 'wajah/' . $row['foto_wajah'] : null,
            'role'       => 'user',
        ]);
    }
}

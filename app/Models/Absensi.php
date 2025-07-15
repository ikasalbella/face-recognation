<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    // Pastikan kolom-kolom ini sesuai dengan tabel absensis di database kamu
    protected $fillable = ['user_id', 'status', 'waktu', 'lokasi'];

    // Relasi ke tabel users
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

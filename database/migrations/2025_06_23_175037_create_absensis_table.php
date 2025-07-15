<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');      // ← siapa yang absen
            $table->string('status');                   // ← berhasil/gagal
            $table->timestamps();                       // ← created_at dipakai sebagai waktu
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};

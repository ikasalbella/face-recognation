<?php

// database/migrations/xxxx_xx_xx_add_jabatan_shift_to_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('jabatan_id')->nullable();
$table->unsignedBigInteger('shift_id')->nullable();

            // Relasi ke tabel jabatans dan shifts
            $table->foreign('jabatan_id')->references('id')->on('jabatans')->onDelete('set null');
            $table->foreign('shift_id')->references('id')->on('shifts')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['jabatan_id']);
            $table->dropForeign(['shift_id']);
            $table->dropColumn(['jabatan_id', 'shift_id']);
        });
    }
};

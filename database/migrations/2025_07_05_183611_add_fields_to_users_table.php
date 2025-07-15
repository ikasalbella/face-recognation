

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nip')->nullable()->after('name');
            $table->string('nomor_hp')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->string('shift')->nullable(); // aktifkan ini kalau memang dibutuhkan
            $table->string('foto_wajah')->nullable()->after('password');
        });
    }

    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            // hanya drop kolom yang benar-benar dibuat oleh migration ini
            $table->dropColumn([
                'nip',
                'nomor_hp',
                'jabatan',
                'tempat_lahir',
                'shift',
                'foto_wajah'
            ]);
        });
    }
};

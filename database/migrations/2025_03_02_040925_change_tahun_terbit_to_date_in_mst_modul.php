<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('mst_modul', function (Blueprint $table) {
            $table->date('tahun_terbit')->change();
        });
    }

    public function down(): void
    {
        Schema::table('mst_modul', function (Blueprint $table) {
            $table->year('tahun_terbit')->change(); // Kembalikan ke YEAR jika rollback
        });
    }
};

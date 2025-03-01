<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('mst_modul', function (Blueprint $table) {
            $table->string('nama_modul', 255)->change(); // Ubah dari char ke string
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mst_modul', function (Blueprint $table) {
            $table->char('nama_modul', 255)->change(); // Kembalikan ke char jika rollback
        });
    }
};

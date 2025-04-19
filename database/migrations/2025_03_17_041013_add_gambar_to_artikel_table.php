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
        Schema::table('artikel', function (Blueprint $table) {
            $table->string('gambar')->nullable()->after('tanggal_rilis'); // Menambahkan kolom gambar setelah tanggal_rilis
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('artikel', function (Blueprint $table) {
            $table->dropColumn('gambar'); // Menghapus kolom gambar jika rollback
        });
    }
};

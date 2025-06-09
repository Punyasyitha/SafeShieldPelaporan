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
        Schema::table('pengaduan', function (Blueprint $table) {
            $table->unsignedBigInteger('userid')->nullable()->after('nama_pengadu'); // Tambahkan kolomnya dulu
            $table->foreign('userid')->references('id')->on('users')->onDelete('set null'); // Baru tambahkan foreign key
        });
    }

    public function down(): void
    {
        Schema::table('pengaduan', function (Blueprint $table) {
            $table->dropForeign(['userid']); // Hapus foreign key-nya dulu
            $table->dropColumn('userid');    // Lalu hapus kolomnya
        });
    }
};

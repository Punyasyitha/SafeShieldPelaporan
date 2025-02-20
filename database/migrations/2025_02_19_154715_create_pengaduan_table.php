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
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->string('idpengaduan', 10); // Primary Key
            $table->string('statusid', 10);
            $table->foreign('statusid')->references('idstatus')->on('mst_sts_pengaduan');
            $table->string('nama_pengadu', 100);
            $table->string('no_telepon', 20);
            $table->string('email')->unique();
            $table->string('nama_terlapor', 100);
            $table->string('tmp_kejadian', 300);
            $table->date('tanggal_kejadian');
            $table->text('detail');
            $table->string('bukti')->nullable(); // File bukti (PDF, gambar, video, rekaman suara)
            $table->string('captcha'); // CAPTCHA untuk verifikasi manusia
            $table->primary('idpengaduan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduan');
    }
};
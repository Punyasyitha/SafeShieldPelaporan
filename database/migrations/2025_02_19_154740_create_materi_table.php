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
        Schema::create('materi', function (Blueprint $table) {
            $table->string('idmateri')->autoIncrement();
            $table->string('modulid', 10);
            $table->foreign('modulid')->references('idmodul')->on('mst_modul');
            $table->string('kategoriid', 10);
            $table->foreign('kategoriid')->references('idkategori')->on('mst_kategori');
            $table->char('judul_materi', 255);
            $table->text('isi_materi');
            $table->char('sumber', 255);
            $table->primary('idmateri');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materi');
    }
};

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
        Schema::create('mst_modul', function (Blueprint $table) {
            $table->string('idmodul',10);
            $table->char('nama_modul',255);
            $table->text('deskripsi');
            $table->year('tahun_terbit');
            $table->primary('idmodul');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_modul');
    }
};
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
        Schema::create('artikel', function (Blueprint $table) {
            $table->string('idartikel', 10);
            $table->string('penulisid', 10);
            $table->foreign('penulisid')->references('idpenulis')->on('mst_penulis');
            $table->char('judul_artikel', 255);
            $table->text('isi_artikel'); // Menambahkan kolom isi_artikel
            $table->date('tanggal_rilis'); // Menambahkan kolom tanggal_rilis
            $table->primary('idartikel');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artikel');
    }
};
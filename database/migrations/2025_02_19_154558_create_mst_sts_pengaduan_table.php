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
        Schema::create('mst_sts_pengaduan', function (Blueprint $table) {
            $table->string('idstatus', 10);
            $table->string('nama_status', 100);
            $table->primary('idstatus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_sts_pengaduan');
    }
};
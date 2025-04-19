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
        Schema::create('submateri', function (Blueprint $table) {
            $table->string('idsubmateri')->autoIncrement();
            $table->string('materiid', 10);
            $table->foreign('materiid')->references('idmateri')->on('materi');
            $table->char('judul_submateri', 255);
            $table->text('isi');
            $table->primary('idsubmateri');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submateri');
    }
};
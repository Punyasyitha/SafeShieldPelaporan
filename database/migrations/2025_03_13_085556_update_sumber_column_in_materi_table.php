<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('materi', function (Blueprint $table) {
            $table->text('sumber')->change(); // Ubah dari char(255) menjadi text
        });
    }

    public function down(): void
    {
        Schema::table('materi', function (Blueprint $table) {
            $table->char('sumber', 255)->change(); // Rollback ke char(255) jika perlu
        });
    }
};
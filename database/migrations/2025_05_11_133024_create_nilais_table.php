<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('nilai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained()->onDelete('cascade');
            $table->unsignedTinyInteger('rencana_kerja'); // 1-100
            $table->unsignedTinyInteger('kehadiran');
            $table->unsignedTinyInteger('disiplin_dan_etika');
            $table->unsignedTinyInteger('keaktifan_kreativitas');
            $table->unsignedTinyInteger('kecermatan');
            $table->unsignedTinyInteger('tanggung_jawab');

            $table->string('huruf_mutu', 2); // A, B+, dll.

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};


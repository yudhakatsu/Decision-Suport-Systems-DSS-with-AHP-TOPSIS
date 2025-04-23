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
        Schema::create('tb_kriteria', function (Blueprint $table) {
            $table->string('kode_kriteria', 16)->primary();
            $table->year('tahun');
            $table->string('nama_kriteria', 256);
            $table->string('atribut', 256)->default('benefit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_kriteria');
    }
};

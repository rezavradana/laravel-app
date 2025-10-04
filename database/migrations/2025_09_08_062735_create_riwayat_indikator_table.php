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
        Schema::create('riwayat_indikator', function (Blueprint $table) {
            $table->string('id_riwayat_indikator', 100)->primary();
            $table->string('id_prediksi', 100);
            $table->string('id_indikator', 100);
            $table->json('nilai');
            $table->datetime('tanggal_tambah');
            $table->foreign('id_prediksi')
                  ->references('id_prediksi')
                  ->on('prediksi')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('id_indikator')
                  ->references('id_indikator')
                  ->on('indikator')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_indikator');
    }
};

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
        Schema::create('keluarga_indikator', function (Blueprint $table) {
            $table->string('id_keluarga_indikator', 100)->primary();
            $table->string('no_kk', 100);
            $table->string('id_indikator', 100);
            $table->integer('nilai');
            $table->datetime('tanggal_tambah');
            $table->datetime('tanggal_update');
            $table->foreign('no_kk')
                  ->references('no_kk')
                  ->on('keluarga')
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
        Schema::dropIfExists('keluarga_indikator');
    }
};

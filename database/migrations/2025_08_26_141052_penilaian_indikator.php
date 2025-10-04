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
        Schema::create('penilaian_indikator', function (Blueprint $table) {
            $table->string('id_penilaian_indikator', 100)->primary();
            $table->string('id_indikator', 100);
            $table->integer('nilai');
            $table->text('deskripsi');
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
        Schema::dropIfExists('penilaian_indikator');
    }
};

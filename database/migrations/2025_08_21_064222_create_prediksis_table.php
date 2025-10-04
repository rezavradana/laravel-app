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
        Schema::create('prediksi', function (Blueprint $table) {
            $table->string('id_prediksi', 100)->primary();
            $table->string('no_kk', 100);
            $table->string('username', 100);
            $table->string('hasil_prediksi', 100);
            $table->decimal('probabilitas', 5, 2);
            $table->datetime('tanggal_prediksi');
            $table->foreign('no_kk')
                  ->references('no_kk')
                  ->on('keluarga')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('username')
                  ->references('username')
                  ->on('users')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prediksi');
    }
};

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
        Schema::create('indikator', function (Blueprint $table) {
            $table->string('id_indikator', 100)->primary();
            $table->string('kode', 100);
            $table->string('nama_input', 100);
            $table->enum('tipe_input', ['select', 'text', 'number', 'textarea', 'radio', 'none'])->default('select');
            $table->text('deskripsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indikator');
    }
};

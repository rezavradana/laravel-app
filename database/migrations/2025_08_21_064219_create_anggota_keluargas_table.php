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
        Schema::create('anggota_keluarga', function (Blueprint $table) {
            $table->string('nik', 100)->primary();
            $table->string('no_kk', 100);
            $table->string('nama', 100);
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin', 100);
            $table->string('agama', 100);
            $table->string('pendidikan', 100);
            $table->string('pekerjaan', 100);
            $table->string('hubungan', 100);
            $table->integer('penghasilan');
            $table->datetime('tanggal_tambah');
            $table->datetime('tanggal_update');
            $table->foreign('no_kk')
                  ->references('no_kk')
                  ->on('keluarga')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota_keluarga');
    }
};

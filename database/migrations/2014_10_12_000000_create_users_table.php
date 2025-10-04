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
        Schema::create('users', function (Blueprint $table) {
            $table->string('username', 100)->primary();
            $table->string('password', 100);
            $table->string('nama', 100)->nullable();
            $table->string('role', 50)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('no_telepon', 20)->nullable();
            $table->string('status', 50)->nullable();
            $table->year('tahun_mulai')->nullable();
            $table->year('tahun_selesai')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

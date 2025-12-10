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
        Schema::disableForeignKeyConstraints();

        Schema::create('jadwal_makan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jadwal');
            $table->time('waktu_jadwal');
            $table->unsignedBigInteger('pengguna_id');
            $table->foreign('pengguna_id')->references('id')->on('pengguna');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_makan');
    }
};

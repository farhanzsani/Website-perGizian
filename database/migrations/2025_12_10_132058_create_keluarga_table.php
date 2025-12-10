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

        Schema::create('keluarga', function (Blueprint $table) {
            $table->id();
            $table->string('nama_keluarga');
            $table->unsignedBigInteger('kepala_keluarga_id');
            $table->foreign('kepala_keluarga_id')->references('id')->on('pengguna');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keluarga');
    }
};

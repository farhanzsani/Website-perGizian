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

        Schema::create('pelacakan_makanan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_konsumsi');
            $table->time('waktu_konsumsi');
            $table->unsignedBigInteger('pengguna_id');
            $table->foreign('pengguna_id')->references('id')->on('pengguna');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelacakan_makanan');
    }
};

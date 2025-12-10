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

        Schema::create('kebutuhan_kalori', function (Blueprint $table) {
            $table->id();
            $table->decimal('skor');
            $table->string('keterangan');
            $table->string('jenis_kelamin');
            $table->decimal('berat_badan');
            $table->decimal('tinggi_badan');
            $table->bigInteger('usia');
            $table->string('aktivitas_fisik');
            $table->timestamps();
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
        Schema::dropIfExists('kebutuhan_kalori');
    }
};

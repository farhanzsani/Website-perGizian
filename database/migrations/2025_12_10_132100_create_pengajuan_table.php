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

        Schema::create('pengajuan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengguna_id');
            $table->foreign('pengguna_id')->references('id')->on('pengguna');
            $table->string('nama_makanan');
            $table->text('foto_gizi')->nullable();
            $table->decimal('kuantitas');
            $table->string('satuan');
            $table->text('foto_makanan');
            $table->decimal('energi');
            $table->decimal('lemak');
            $table->decimal('protein');
            $table->decimal('karbohidrat');
            $table->string('status_pengajuan');
            $table->string('kategori_makanan');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan');
    }
};

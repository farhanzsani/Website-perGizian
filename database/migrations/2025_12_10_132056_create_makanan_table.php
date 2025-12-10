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

        Schema::create('makanan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->decimal('energi');
            $table->decimal('lemak');
            $table->decimal('protein');
            $table->decimal('karbohidrat');
            $table->unsignedBigInteger('kategori_makanan_id');
            $table->foreign('kategori_makanan_id')->references('id')->on('Kategori_Makanan');
            $table->text('foto_gizi');
            $table->text('foto_makanan');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('makanan');
    }
};

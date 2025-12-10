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
        Schema::create('detail_artikel', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kategori_artikel_id');
            $table->foreign('kategori_artikel_id')->references('id')->on('kategori_artikel');
            $table->unsignedBigInteger('artikel_id');
            $table->foreign('artikel_id')->references('id')->on('artikel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_artikel');
    }
};

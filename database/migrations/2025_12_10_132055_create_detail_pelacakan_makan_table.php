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

        Schema::create('detail_pelacakan_makan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelacakan_makanan_id');
            $table->foreign('pelacakan_makanan_id')->references('id')->on('Pelacakan_Makanan');
            $table->unsignedBigInteger('makanan_id');
            $table->foreign('makanan_id')->references('id')->on('Makanan');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pelacakan_makan');
    }
};

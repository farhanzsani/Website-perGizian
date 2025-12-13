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

        // Relasi
        $table->unsignedBigInteger('pengguna_id');
        $table->unsignedBigInteger('makanan_id');

        // Data Tracking
        $table->date('tanggal_konsumsi');
        $table->time('waktu_konsumsi'); // Untuk mencatat jam makan (07:00, 12:30, dll)
        $table->decimal('jumlah_porsi', 8, 2);  // Contoh: 1.5 (porsi/gram)
        $table->decimal('total_kalori', 10, 2); // Contoh: 250.00 (kkal)

        $table->timestamps();

        // Foreign Keys
        $table->foreign('pengguna_id')->references('id')->on('pengguna')->onDelete('cascade');
        $table->foreign('makanan_id')->references('id')->on('makanan')->onDelete('cascade');
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

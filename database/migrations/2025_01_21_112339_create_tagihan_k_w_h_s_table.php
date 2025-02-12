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
        Schema::create('tagihan_kwh', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->nullable()->constrained('pelanggans')->cascadeOnDelete();
            $table->foreignId('penggunaan_kwh_id')->nullable()->constrained('penggunaan_kwh')->cascadeOnDelete();
            $table->string('bulan');
            $table->string('tahun');
            $table->string('jumlah_meter');
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihan_k_w_h_s');
    }
};

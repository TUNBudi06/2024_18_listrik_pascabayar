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
        Schema::create('pembayaran_kwh', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tagihan_kwh_id')->constrained('tagihan_kwh')->cascadeOnDelete();
            $table->foreignId('pelanggan_id')->constrained('pelanggans')->cascadeOnDelete();
            $table->string('total_tagihan');
            $table->string('biaya_admin');
            $table->string('total_bayar')->nullable();
            $table->date('tanggal_pembayaran');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_k_w_h_s');
    }
};

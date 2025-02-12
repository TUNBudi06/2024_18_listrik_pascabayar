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
        Schema::create('tarif_kwh', function (Blueprint $table) {
            $table->id();
            $table->string('daya');
            $table->string('tarif_perkwh');
            $table->timestamps();
        });

        Schema::table('pelanggans', function (Blueprint $table) {
            $table->foreignId('tarif_kwh_id')->constrained('tarif_kwh')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarif_kwh');
    }
};

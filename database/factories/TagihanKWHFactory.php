<?php

namespace Database\Factories;

use App\Models\PenggunaanKWH;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TagihanKWH>
 */
class TagihanKWHFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $penggunaan = PenggunaanKWH::factory()->create();

        return [
            'pelanggan_id' => $penggunaan->pelanggan_id, // Sesuaikan dengan jumlah pelanggan
            'penggunaan_kwh_id' => $penggunaan->id, // Sesuaikan dengan jumlah penggunaan KWH
            'bulan' => $penggunaan->bulan,
            'tahun' => $penggunaan->tahun,
            'jumlah_meter' => $penggunaan->meter_akhir - $penggunaan->meter_awal,
            'status' => 0, // Status acak (0: belum dibayar, 1: sudah dibayar)
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}

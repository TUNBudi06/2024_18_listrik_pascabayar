<?php

namespace Database\Factories;

use App\Models\TagihanKWH;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PembayaranKWH>
 */
class PembayaranKWHFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tagihanKWH = TagihanKWH::with('PelangganKWH')->where('status', 0)->inRandomOrder()->first();

        if (! $tagihanKWH) {
            return [];
        }

        $randBool = $this->faker->boolean();
        $total_bayar = null;
        $tanggal_bayar = null;
        if ($randBool) {
            $tagihanKWH->update([
                'status' => 1,
            ]);
            $total_bayar = ($tagihanKWH->PelangganKWH->getTarif->tarif_perkwh * $tagihanKWH->jumlah_meter) + $this->faker->numberBetween(105000, 505000);
            $tanggal_bayar = $this->faker->dateTimeThisYear();
        }

        return [
            'tagihan_kwh_id' => $tagihanKWH->id, // Sesuaikan dengan jumlah tagihan
            'pelanggan_id' => $tagihanKWH->pelanggan_id, // Sesuaikan dengan jumlah pelanggan
            'total_tagihan' => $tagihanKWH->PelangganKWH->getTarif->tarif_perkwh * $tagihanKWH->jumlah_meter,
            'biaya_admin' => $this->faker->numberBetween(1000, 5000),
            'total_bayar' => $total_bayar,
            'tanggal_pembayaran' => $tanggal_bayar,
            'user_id' => $this->faker->numberBetween(1, 2), // Hanya user dengan level admin (1 atau 2)
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}

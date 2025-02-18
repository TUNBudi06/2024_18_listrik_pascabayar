<?php

namespace Database\Factories;

use App\Models\Pelanggan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PenggunaanKWH>
 */
class PenggunaanKWHFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pelanggan_id' => Pelanggan::inRandomOrder()->first()->id, // Sesuaikan dengan jumlah pelanggan
            'bulan' => $this->faker->monthName(),
            'tahun' => $this->faker->year(),
            'meter_awal' => $this->faker->numberBetween(100, 500),
            'meter_akhir' => $this->faker->numberBetween(500, 1000),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}

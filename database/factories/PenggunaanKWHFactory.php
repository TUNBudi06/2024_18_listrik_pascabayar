<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
            'bulan' => $this->faker->monthName(),
            'tahun' => $this->faker->year(),
            'meter_awal' => $this->faker->randomNumber(5),
            'meter_akhir' => $this->faker->randomNumber(5),
        ];
    }
}

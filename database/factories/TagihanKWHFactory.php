<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'bulan' => $this->faker->monthName(),
            'tahun' => $this->faker->year(),
            'jumlah_meter' => $this->faker->randomNumber(5),
            'status' => $this->faker->boolean(),
        ];
    }
}

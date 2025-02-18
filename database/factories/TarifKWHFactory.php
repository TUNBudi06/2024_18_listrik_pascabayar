<?php

namespace Database\Factories;

use App\Models\TarifKWH;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TarifKWHFactory extends Factory
{
    protected $model = TarifKWH::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $rand = $this->faker->numberBetween(900, 22000);

        return [
            'daya' => $rand,
            'tarif_perkwh' => $rand * 0.6,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\AdminLevel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AdminLevelFactory extends Factory
{
    protected $model = AdminLevel::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->randomElement(['Admin', 'Bank']),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\TarifKWH;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pelanggan>
 */
class PelangganFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => $this->faker->unique()->userName(),
            'password' => Hash::make('12345678'),
            'nama_pelanggan' => $this->faker->name(),
            'alamat' => $this->faker->address(),
            'nomor_kwh' => $this->faker->unique()->randomNumber(8),
            'tarif_kwh_id' => TarifKWH::inRandomOrder()->first()?->id ?? 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}

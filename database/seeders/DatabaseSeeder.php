<?php

namespace Database\Seeders;

use App\Models\AdminLevel;
use App\Models\Pelanggan;
use App\Models\TarifKWH;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        AdminLevel::insert([
            [
                'nama' => 'Admin',
            ],
            [
                'nama' => 'Bank',
            ]
        ]);

        User::factory()->create([
            'name' => 'tunbudi06',
            'username' => 'tunbudi06',
            'admin_level_id' => 1
        ]);

        TarifKWH::insert([[
            'daya' => 900,
            'tarif_perkwh' =>1320
        ],
            [
                'daya' => 1300,
                'tarif_perkwh' => 1500
            ],
            [
                'daya' => 2200,
                'tarif_perkwh' => 2000
            ],
            [
                'daya' => 3500,
                'tarif_perkwh' => 2500
            ],
            [
                'daya' => 4400,
                'tarif_perkwh' => 2800
            ],
            [
                'daya' => 5500,
                'tarif_perkwh' => 3500
            ],
            [
                'daya' => 6600,
                'tarif_perkwh' => 4400
            ],
            [
                'daya' => 7700,
                'tarif_perkwh' => 5500
            ],
            [
                'daya' => 10600,
                'tarif_perkwh' => 6500
            ],
            [
                'daya' => 13000,
                'tarif_perkwh' => 6600
            ],
            [
                'daya' => 22000,
                'tarif_perkwh' => 7700
            ]
        ]);

        Pelanggan::factory()->create(
            [
                'username' => 'pelanggan',
                'nama_pelanggan' => 'Pelanggan',
                'alamat' => 'Jl. Pelanggan',
                'nomor_kwh' => '12345678',
                'tarif_kwh_id' => 1
            ]
        );
    }
}

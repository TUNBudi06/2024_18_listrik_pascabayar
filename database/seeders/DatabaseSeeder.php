<?php

namespace Database\Seeders;

use App\Models\AdminLevel;
use App\Models\Pelanggan;
use App\Models\PembayaranKWH;
use App\Models\PenggunaanKWH;
use App\Models\TagihanKWH;
use App\Models\TarifKWH;
use App\Models\User;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    //    public function run(): void
    //    {
    //        // User::factory(10)->create();
    //
    //        AdminLevel::insert([
    //            [
    //                'nama' => 'Admin',
    //            ],
    //            [
    //                'nama' => 'Bank',
    //            ],
    //        ]);
    //
    //        User::factory()->create([
    //            'name' => 'tunbudi06',
    //            'username' => 'tunbudi06',
    //            'admin_level_id' => 1,
    //        ]);
    //
    //        TarifKWH::insert([[
    //            'daya' => 900,
    //            'tarif_perkwh' => 1320,
    //        ],
    //            [
    //                'daya' => 1300,
    //                'tarif_perkwh' => 1500,
    //            ],
    //            [
    //                'daya' => 2200,
    //                'tarif_perkwh' => 2000,
    //            ],
    //            [
    //                'daya' => 3500,
    //                'tarif_perkwh' => 2500,
    //            ],
    //            [
    //                'daya' => 4400,
    //                'tarif_perkwh' => 2800,
    //            ],
    //            [
    //                'daya' => 5500,
    //                'tarif_perkwh' => 3500,
    //            ],
    //            [
    //                'daya' => 6600,
    //                'tarif_perkwh' => 4400,
    //            ],
    //            [
    //                'daya' => 7700,
    //                'tarif_perkwh' => 5500,
    //            ],
    //            [
    //                'daya' => 10600,
    //                'tarif_perkwh' => 6500,
    //            ],
    //            [
    //                'daya' => 13000,
    //                'tarif_perkwh' => 6600,
    //            ],
    //            [
    //                'daya' => 22000,
    //                'tarif_perkwh' => 7700,
    //            ],
    //        ]);
    //
    //        Pelanggan::factory()->create(
    //            [
    //                'username' => 'pelanggan',
    //                'nama_pelanggan' => 'Pelanggan',
    //                'alamat' => 'Jl. Pelanggan',
    //                'nomor_kwh' => '12345678',
    //                'tarif_kwh_id' => 1,
    //            ]
    //        );
    //
    //        PenggunaanKWH::insert([
    //            [
    //                'id' => 1,
    //                'pelanggan_id' => 1,
    //                'bulan' => Carbon::now()->subMonths(2)->format('F'),
    //                'tahun' => 2024,
    //                'meter_awal' => 100,
    //                'meter_akhir' => 200,
    //            ],
    //            [
    //                'id' => 2,
    //                'pelanggan_id' => 1,
    //                'bulan' => Carbon::now()->subMonths(1)->format('F'),
    //                'tahun' => 2024,
    //                'meter_awal' => 100,
    //                'meter_akhir' => 200,
    //            ],
    //            [
    //                'id' => 3,
    //                'pelanggan_id' => 1,
    //                'bulan' => Carbon::now()->subMonths(0)->format('F'),
    //                'tahun' => 2025,
    //                'meter_awal' => 100,
    //                'meter_akhir' => 200,
    //            ],
    //        ]);
    //
    //        TagihanKWH::insert([
    //            [
    //                'id' => 1,
    //                'pelanggan_id' => 1,
    //                'penggunaan_kwh_id' => 1,
    //                'bulan' => Carbon::now()->subMonths(2)->format('F'),
    //                'tahun' => 2024,
    //                'jumlah_meter' => 100,
    //                'status' => 1,
    //            ],
    //            [
    //                'id' => 2,
    //                'pelanggan_id' => 1,
    //                'penggunaan_kwh_id' => 2,
    //                'bulan' => Carbon::now()->subMonths(1)->format('F'),
    //                'tahun' => 2025,
    //                'jumlah_meter' => 100,
    //                'status' => 1,
    //            ],
    //            [
    //                'id' => 3,
    //                'pelanggan_id' => 1,
    //                'penggunaan_kwh_id' => 3,
    //                'bulan' => Carbon::now()->subMonths(0)->format('F'),
    //                'tahun' => 2025,
    //                'jumlah_meter' => 100,
    //                'status' => 0,
    //            ],
    //        ]);
    //
    //        PembayaranKWH::insert([
    //            [
    //                'tagihan_kwh_id' => 1,
    //                'pelanggan_id' => 1,
    //                'total_tagihan' => 1000,
    //                'biaya_admin' => 0,
    //                'total_bayar' => 1000,
    //                'tanggal_pembayaran' => '2025-01-21',
    //                'user_id' => 1,
    //                'created_at' => now(),
    //            ],
    //            [
    //                'tagihan_kwh_id' => 2,
    //                'pelanggan_id' => 1,
    //                'total_tagihan' => 1000,
    //                'biaya_admin' => 0,
    //                'total_bayar' => 1000,
    //                'tanggal_pembayaran' => '2025-01-21',
    //                'user_id' => 1,
    //                'created_at' => now(),
    //            ],
    //        ]);
    //
    //        PembayaranKWH::create(
    //            [
    //                'tagihan_kwh_id' => 3,
    //                'pelanggan_id' => 1,
    //                'total_tagihan' => 50000,
    //                'biaya_admin' => 2500,
    //                'user_id' => 1,
    //            ]);
    //    }

    public function run(): void
    {
        // Buat 2 level admin
        AdminLevel::insert([
            ['nama' => 'Admin'],
            ['nama' => 'Bank'],
        ]);

        // Buat 2 user (1 Admin dan 1 Bank)
        User::factory()->create([
            'name' => 'Admin User',
            'username' => 'admin',
            'admin_level_id' => 1, // Admin
        ]);

        User::factory()->create([
            'name' => 'Bank User',
            'username' => 'bank',
            'admin_level_id' => 2, // Bank
        ]);
        TarifKWH::factory()->count(11)->create();
        Pelanggan::factory(50)->create();
        TagihanKWH::factory(600)->create();
        PembayaranKWH::factory(600)->create();
    }
}

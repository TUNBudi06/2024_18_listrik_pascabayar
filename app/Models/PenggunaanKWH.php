<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenggunaanKWH extends Model
{
    /** @use HasFactory<\Database\Factories\PenggunaanKWHFactory> */
    use HasFactory;

    protected $table = 'penggunaan_kwh';

    protected $fillable = [
        'pelanggan_id',
        'bulan',
        'tahun',
        'meter_awal',
        'meter_akhir',
    ];

    protected $casts = [
        'pelanggan_id' => 'integer',
        'bulan' => 'string',
        'tahun' => 'integer',
        'meter_awal' => 'integer',
        'meter_akhir' => 'integer',
    ];

    public $timestamps = true;

    //    public function
}

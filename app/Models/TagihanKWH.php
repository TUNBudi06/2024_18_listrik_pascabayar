<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagihanKWH extends Model
{
    /** @use HasFactory<\Database\Factories\TagihanKWHFactory> */
    use HasFactory;

    protected $table = 'tagihan_kwh';

    protected $fillable = [
        'pelanggan_id',
        'penggunaan_kwh_id',
        'bulan',
        'tahun',
        'jumlah_meter',
        'status',
    ];

    public $timestamps = true;

    protected $casts = [
        'pelanggan_id' => 'integer',
        'penggunaan_kwh_id' => 'integer',
        'bulan' => 'string',
        'tahun' => 'string',
        'jumlah_meter' => 'integer',
        'status' => 'boolean',
    ];

    public function PembayaranKWH()
    {
        return $this->hasOne(PembayaranKWH::class, 'tagihan_kwh_id', 'id');
    }

    public function PelangganKWH()
    {
        return $this->hasOne(Pelanggan::class, 'id', 'pelanggan_id');
    }
}

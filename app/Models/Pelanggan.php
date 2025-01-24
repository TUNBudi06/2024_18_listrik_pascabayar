<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pelanggan extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\PelangganFactory> */
    use HasFactory;

    protected $table = 'pelanggans';

    protected $fillable = ['username', 'password', 'nama_pelanggan', 'alamat', 'nomor_kwh', 'tarif_kwh_id'];

    protected $casts = [
        'id_pelanggan' => 'integer',
        'nomor_kwh' => 'integer',
    ];

    protected $hidden = ['password'];

    public function getTarif()
    {
        return $this->hasOne(TarifKWH::class, 'id', 'tarif_kwh_id');
    }

    public function PenggunaanKWH()
    {
        return $this->hasMany(PenggunaanKWH::class, 'pelanggan_id', 'id');
    }

    public function TagihanKWH()
    {
        return $this->hasMany(TagihanKWH::class, 'pelanggan_id', 'id');
    }

    public function PembayaranKWH()
    {
        return $this->hasMany(PembayaranKWH::class, 'pelanggan_id', 'id')->with(['tagihanKWH']);
    }
}

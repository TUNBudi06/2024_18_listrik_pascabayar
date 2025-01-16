<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pelanggan extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\PelangganFactory> */
    use HasFactory;

    protected $table = 'pelanggans';
    protected $fillable = ['username', 'password', 'nama_pelanggan', 'alamat', 'nomor_kwh','tarif_kwh_id'];

    protected $casts = [
        'id_pelanggan' => 'integer',
        'nomor_kwh' => 'integer'
    ];

    public function getTarif()
    {
        return $this->belongsTo(TarifKWH::class, 'tarif_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranKWH extends Model
{
    /** @use HasFactory<\Database\Factories\PembayaranKWHFactory> */
    use HasFactory;

    protected $table = 'pembayaran_kwh';

    protected $fillable = [
        'tagihan_kwh_id',
        'pelanggan_id',
        'total_tagihan',
        'biaya_admin',
        'total_bayar',
        'tanggal_pembayaran',
        'user_id',
    ];

    protected $casts = [
        'tanggal_pembayaran' => 'date',
        'total_tagihan' => 'float',
        'biaya_admin' => 'float',
        'total_bayar' => 'float',
    ];

    public function tagihanKWH()
    {
        return $this->hasOne(TagihanKWH::class, 'id', 'tagihan_kwh_id');
    }

    public function userAdmin()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function pelangganKWH()
    {
        return $this->hasOne(Pelanggan::class, 'id', 'pelanggan_id');
    }
}

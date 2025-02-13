<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $tagihan_kwh_id
 * @property int $pelanggan_id
 * @property float $total_tagihan
 * @property float $biaya_admin
 * @property float|null $total_bayar
 * @property \Illuminate\Support\Carbon|null $tanggal_pembayaran
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TFactory|null $use_factory
 * @property-read \App\Models\Pelanggan|null $pelangganKWH
 * @property-read \App\Models\TagihanKWH|null $tagihanKWH
 * @property-read \App\Models\User|null $userAdmin
 *
 * @method static \Database\Factories\PembayaranKWHFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PembayaranKWH newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PembayaranKWH newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PembayaranKWH query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PembayaranKWH whereBiayaAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PembayaranKWH whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PembayaranKWH whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PembayaranKWH wherePelangganId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PembayaranKWH whereTagihanKwhId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PembayaranKWH whereTanggalPembayaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PembayaranKWH whereTotalBayar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PembayaranKWH whereTotalTagihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PembayaranKWH whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PembayaranKWH whereUserId($value)
 *
 * @mixin \Eloquent
 */
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

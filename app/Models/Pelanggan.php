<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property int $id
 * @property string $nama_pelanggan
 * @property string $username
 * @property string $password
 * @property string $alamat
 * @property int $nomor_kwh
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $tarif_kwh_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PembayaranKWH> $PembayaranKWH
 * @property-read int|null $pembayaran_k_w_h_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PenggunaanKWH> $PenggunaanKWH
 * @property-read int|null $penggunaan_k_w_h_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TagihanKWH> $TagihanKWH
 * @property-read int|null $tagihan_k_w_h_count
 * @property-read \App\Models\TFactory|null $use_factory
 *
 * @method static \Database\Factories\PelangganFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereNamaPelanggan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereNomorKwh($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereTarifKwhId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereUsername($value)
 *
 * @mixin \Eloquent
 */
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

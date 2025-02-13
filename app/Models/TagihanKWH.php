<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int|null $pelanggan_id
 * @property int|null $penggunaan_kwh_id
 * @property string $bulan
 * @property string $tahun
 * @property int $jumlah_meter
 * @property bool $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Pelanggan|null $PelangganKWH
 * @property-read \App\Models\PembayaranKWH|null $PembayaranKWH
 * @property-read \App\Models\PenggunaanKWH|null $PenggunaanKWH
 * @property-read \App\Models\TFactory|null $use_factory
 *
 * @method static \Database\Factories\TagihanKWHFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TagihanKWH newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TagihanKWH newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TagihanKWH query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TagihanKWH whereBulan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TagihanKWH whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TagihanKWH whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TagihanKWH whereJumlahMeter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TagihanKWH wherePelangganId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TagihanKWH wherePenggunaanKwhId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TagihanKWH whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TagihanKWH whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TagihanKWH whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
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
        return $this->hasOne(Pelanggan::class, 'id', 'pelanggan_id')->with(['getTarif']);
    }

    public function PenggunaanKWH()
    {
        return $this->hasOne(PenggunaanKWH::class, 'id', 'penggunaan_kwh_id');
    }
}

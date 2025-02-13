<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int|null $pelanggan_id
 * @property string $bulan
 * @property int $tahun
 * @property int $meter_awal
 * @property int $meter_akhir
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TFactory|null $use_factory
 *
 * @method static \Database\Factories\PenggunaanKWHFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenggunaanKWH newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenggunaanKWH newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenggunaanKWH query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenggunaanKWH whereBulan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenggunaanKWH whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenggunaanKWH whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenggunaanKWH whereMeterAkhir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenggunaanKWH whereMeterAwal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenggunaanKWH wherePelangganId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenggunaanKWH whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenggunaanKWH whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
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

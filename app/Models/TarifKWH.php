<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $daya
 * @property string $tarif_perkwh
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TarifKWH newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TarifKWH newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TarifKWH query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TarifKWH whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TarifKWH whereDaya($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TarifKWH whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TarifKWH whereTarifPerkwh($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TarifKWH whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class TarifKWH extends Model
{
    protected $table = 'tarif_kwh';

    protected $fillable = ['daya', 'tarif_perkwh'];

    protected $casts = [
        'daya' => 'integer',
        'tarif_perkwh' => 'string',
    ];

    public function getPelanggan()
    {
        return $this->hasMany(Pelanggan::class, 'tarif_kwh_id', 'id');
    }
}

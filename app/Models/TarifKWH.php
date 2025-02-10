<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

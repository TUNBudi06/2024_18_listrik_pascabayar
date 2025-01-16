<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminLevel extends Model
{
    protected $table = 'admin_levels';
    protected $fillable = ['nama'];

    protected $casts = [
        'nama' => 'string',
    ];
}

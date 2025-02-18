<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nama
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminLevel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminLevel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminLevel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminLevel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminLevel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminLevel whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminLevel whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class AdminLevel extends Model
{
    use HasFactory;

    protected $table = 'admin_levels';

    protected $fillable = ['nama'];

    protected $casts = [
        'nama' => 'string',
    ];
}

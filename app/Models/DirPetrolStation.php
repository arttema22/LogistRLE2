<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DirPetrolStation extends Model
{
    use HasFactory;

    protected $fillable = [
        'station_id',
        'name',
        'address',
    ];

    /**
     * Получить данные о заправках на АЗС.
     */
    public function refillings(): HasMany
    {
        return $this->hasMany(Refilling::class, 'station_id', 'id');
    }
}

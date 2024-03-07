<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DirTruckType extends Model
{
    use HasFactory;

    /**
     * Получить все автомобили к типу.
     */
    public function truck(): HasMany
    {
        return $this->hasMany(Truck::class, 'type_id', 'id');
    }
}

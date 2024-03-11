<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use MoonShine\ChangeLog\Traits\HasChangeLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DirTruckType extends Model
{
    use HasFactory, SoftDeletes, HasChangeLog;

    /**
     * Получить все автомобили к типу.
     */
    public function truck(): HasMany
    {
        return $this->hasMany(Truck::class, 'type_id', 'id');
    }
}

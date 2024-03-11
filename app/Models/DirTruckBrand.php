<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use MoonShine\ChangeLog\Traits\HasChangeLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DirTruckBrand extends Model
{
    use HasFactory, SoftDeletes, HasChangeLog;

    /**
     * Получить все автомобили к бренду.
     */
    public function truck(): HasMany
    {
        return $this->hasMany(Truck::class, 'brand_id', 'id');
    }
}

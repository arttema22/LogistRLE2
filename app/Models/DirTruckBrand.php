<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DirTruckBrand extends Model
{
    use HasFactory;

    /**
     * Получить все автомобили к бренду.
     */
    public function truck(): HasMany
    {
        return $this->hasMany(Truck::class, 'brand_id', 'id');
    }
}

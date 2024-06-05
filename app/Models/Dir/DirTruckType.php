<?php

namespace App\Models\Dir;

use App\Models\Sys\Truck;
use App\Models\Tariff\TariffDistance;
use Illuminate\Database\Eloquent\Model;
use MoonShine\ChangeLog\Traits\HasChangeLog;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DirTruckType extends Model
{
    use HasFactory, HasChangeLog;

    protected $fillable = [
        'name'
    ];

    /**
     * tariff
     *
     * @return HasOne
     *  Получить тарифы для типа авто
     */
    public function tariff(): HasOne
    {
        return $this->hasOne(TariffDistance::class, 'truck_type_id');
    }

    /**
     * Получить все автомобили к типу.
     */
    public function truck(): HasMany
    {
        return $this->hasMany(Truck::class, 'type_id', 'id');
    }
}

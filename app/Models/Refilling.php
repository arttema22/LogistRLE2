<?php

namespace App\Models;

use App\Models\Sys\Truck;
use App\Models\Dir\DirFuelType;
use MoonShine\Models\MoonshineUser;
use App\Models\Dir\DirPetrolStation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use MoonShine\ChangeLog\Traits\HasChangeLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Refilling extends Model
{
    use HasFactory, SoftDeletes, HasChangeLog, MassPrunable;

    protected $fillable = [
        'date',
        'owner_id',
        'driver_id',
        'volume',
        'price',
        'sum',
        'station_id',
        'fuel_type_id',
        'truck_id',
        'comment',
        'integration_id',
        'profit_id',
    ];

    /**
     * Получить данные о создателе записи.
     */
    public function owner()
    {
        return $this->belongsTo(MoonshineUser::class, 'owner_id', 'id');
    }

    /**
     * Получить данные о водителе.
     */
    public function driver()
    {
        return $this->belongsTo(MoonshineUser::class, 'driver_id', 'id');
    }

    /**
     * petrolStation
     * Получить данные о АЗС.
     * @return void
     */
    public function petrolStation()
    {
        return $this->belongsTo(DirPetrolStation::class, 'station_id', 'id');
    }

    /**
     * fuelTupe
     * Получить данные о типе топлива
     * @return void
     */
    public function fuelType()
    {
        return $this->belongsTo(DirFuelType::class, 'fuel_type_id', 'id');
    }

    /**
     * Получить данные об автомобиле который заправляется.
     */
    public function truck()
    {
        return $this->belongsTo(Truck::class, 'truck_id', 'id');
    }

    /**
     * prunable
     * Запрос для удаления устаревших записей модели.
     * @return Builder
     */
    public function prunable(): Builder
    {
        return static::where('deleted_at', '<=', now()->subDay());
    }
}

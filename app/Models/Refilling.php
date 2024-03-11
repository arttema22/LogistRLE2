<?php

namespace App\Models;

use MoonShine\Models\MoonshineUser;
use Illuminate\Database\Eloquent\Model;
use MoonShine\ChangeLog\Traits\HasChangeLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Refilling extends Model
{
    use HasFactory, SoftDeletes, HasChangeLog;

    protected $fillable = [
        'date',
        'owner_id',
        'driver_id',
        'num_liters_car_refueling',
        'price_car_refueling',
        'cost_car_refueling',
        'station_id',
        'truck_id',

        'reg_number',
        'integration_id',
        'profit_id',
    ];

    /**
     * Получить данные о создателе записи о заправке.
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
     * Получить данные о АЗС.
     */
    public function petrolStation()
    {
        return $this->belongsTo(DirPetrolStation::class, 'station_id', 'id');
    }

    /**
     * Получить данные об автомобиле который заправляется.
     */
    public function truck()
    {
        return $this->belongsTo(Truck::class, 'truck_id', 'id');
    }
}

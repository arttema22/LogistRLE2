<?php

namespace App\Models;

use MoonShine\Models\MoonshineUser;
use Illuminate\Database\Eloquent\Model;
use MoonShine\ChangeLog\Traits\HasChangeLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Refilling extends Model
{
    use HasFactory, HasChangeLog;

    protected $fillable = [
        'date',
        'owner_id',
        'driver_id',
        'num_liters_car_refueling',
        'price_car_refueling',
        'cost_car_refueling',
        'station_id',
        'brand',
        'address',
        'reg_number',
        'driver',
        'driver_phone',
        'inegration_id',
        'profit_id',
        'comment',
        'status',
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
}

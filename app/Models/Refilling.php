<?php

namespace App\Models;

use MoonShine\Models\MoonshineUser;
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
        'truck_id',
        'reg_number',
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
     * Получить данные об автомобиле который заправляется.
     */
    public function truck()
    {
        return $this->belongsTo(Truck::class, 'truck_id', 'id');
    }

    /**
     * Запрос для удаления устаревших записей модели.
     */
    public function prunable(): Builder
    {
        return static::where('deleted_at', '<=', now()->subDay());
    }
}

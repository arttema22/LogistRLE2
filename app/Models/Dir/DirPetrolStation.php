<?php

namespace App\Models\Dir;

use App\Models\Refilling;
use Illuminate\Database\Eloquent\Model;
use App\Models\Dir\DirPetrolStationBrand;
use Illuminate\Database\Eloquent\Builder;
use MoonShine\ChangeLog\Traits\HasChangeLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * DirPetrolStation
 */
class DirPetrolStation extends Model
{
    use HasFactory, SoftDeletes, HasChangeLog, MassPrunable;

    protected $fillable = [
        'address',
        'dir_petrol_station_brand_id',
        'station_num',
    ];

    /**
     * petrolStationBrand
     * Получить данные о бренде.
     * @return void
     */
    public function petrolStationBrand()
    {
        return $this->belongsTo(DirPetrolStationBrand::class, 'dir_petrol_station_brand_id', 'id');
    }

    /**
     * refillings
     * Получить данные о заправках на АЗС.
     * @return HasMany
     */
    public function refillings(): HasMany
    {
        return $this->hasMany(Refilling::class, 'dir_petrol_station_id', 'id');
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

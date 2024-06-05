<?php

namespace App\Models\Sys;

use App\Models\Refilling;
use App\Models\Dir\DirTruckType;
use App\Models\Dir\DirTruckBrand;
use App\Models\Sys\MoonshineUser as SysMoonshineUser;
use MoonShine\Models\MoonshineUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use MoonShine\ChangeLog\Traits\HasChangeLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Truck extends Model
{
    use HasFactory, SoftDeletes, HasChangeLog, MassPrunable;

    protected $fillable = [
        'reg_num_ru',
        'reg_num_en',
        'brand_id',
        'type_id',
        'driver_id',
        'name'
    ];

    /**
     * driver
     *
     * @return BelongsTo
     */
    public function driver(): BelongsTo
    {
        return $this->belongsTo(SysMoonshineUser::class, 'driver_id', 'id');
    }

    /**
     * refillings
     * Получить данные о заправках.
     * @return HasMany
     */
    public function refillings(): HasMany
    {
        return $this->hasMany(Refilling::class, 'truck_id', 'id');
    }



    /**
     * Получить бренд, которому принадлежит автомобиль.
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(DirTruckBrand::class, 'brand_id', 'id');
    }

    /**
     * Получить тип, которому принадлежит автомобиль.
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(DirTruckType::class, 'type_id', 'id');
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

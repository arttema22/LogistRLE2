<?php

namespace App\Models\Dir;

use App\Models\Tariff\TariffRoute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use MoonShine\ChangeLog\Traits\HasChangeLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * DirRouteAddress
 */
class DirRouteAddress extends Model
{
    use HasFactory, SoftDeletes, HasChangeLog, MassPrunable;

    protected $fillable = [
        'name',
    ];

    /**
     * start
     *
     * @return HasMany
     * Получить все записи с точкой старта
     */
    public function start(): HasMany
    {
        return $this->hasMany(TariffRoute::class, 'start_id');
    }


    /**
     * finish
     *
     * @return HasMany
     * Получить все записи с точкой финиша
     */
    public function finish(): HasMany
    {
        return $this->hasMany(TariffRoute::class, 'finish_id');
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

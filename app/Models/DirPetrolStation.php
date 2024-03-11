<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use MoonShine\ChangeLog\Traits\HasChangeLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DirPetrolStation extends Model
{
    use HasFactory, SoftDeletes, HasChangeLog, MassPrunable;

    protected $fillable = [
        'station_id',
        'name',
        'address',
    ];

    /**
     * Получить данные о заправках на АЗС.
     */
    public function refillings(): HasMany
    {
        return $this->hasMany(Refilling::class, 'station_id', 'id');
    }

    /**
     * Запрос для удаления устаревших записей модели.
     */
    public function prunable(): Builder
    {
        return static::onlyTrashed()
            ->where('created_at', '<=', now()->subMonth());
    }
}

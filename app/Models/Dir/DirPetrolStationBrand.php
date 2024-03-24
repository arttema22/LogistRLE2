<?php

namespace App\Models\Dir;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use MoonShine\ChangeLog\Traits\HasChangeLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * DirPetrolStationBrand
 */
class DirPetrolStationBrand extends Model
{
    use HasFactory, SoftDeletes, HasChangeLog, MassPrunable;

    protected $fillable = [
        'name',
    ];

    /**
     * petrolStations
     * Получить данные о заправочных станциях
     * @return HasMany
     */
    public function petrolStations(): HasMany
    {
        return $this->hasMany(DirPetrolStation::class, 'brand_id', 'id');
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

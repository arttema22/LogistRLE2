<?php

namespace App\Models\Dir;

use App\Models\Refilling;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use MoonShine\ChangeLog\Traits\HasChangeLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DirFuelType extends Model
{
    use HasFactory, SoftDeletes, HasChangeLog, MassPrunable;

    protected $fillable = [
        'name',
        'dir_fuel_category_id',
    ];

    /**
     * fuelTupe
     * Получить данные о категории топлива.
     * @return void
     */
    public function fuelCategory()
    {
        return $this->belongsTo(DirFuelCategory::class, 'dir_fuel_category_id', 'id');
    }

    /**
     * refillings
     * Получить данные о заправках.
     * @return HasMany
     */
    public function refillings(): HasMany
    {
        return $this->hasMany(Refilling::class, 'dir_fuel_type_id', 'id');
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

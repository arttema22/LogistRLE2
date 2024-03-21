<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use MoonShine\ChangeLog\Traits\HasChangeLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DirFuelCategory extends Model
{
    use HasFactory, SoftDeletes, HasChangeLog, MassPrunable;

    protected $fillable = [
        'name',
    ];

    /**
     * refillings
     * Получить данные о типах горючего
     * @return HasMany
     */
    public function fuelType(): HasMany
    {
        return $this->hasMany(DirFuelType::class, 'category_id', 'id');
    }
}

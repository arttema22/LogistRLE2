<?php

namespace App\Models;

use MoonShine\Models\MoonshineUser;
use Illuminate\Database\Eloquent\Model;
use MoonShine\ChangeLog\Traits\HasChangeLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Truck extends Model
{
    use HasFactory, SoftDeletes, HasChangeLog;

    protected $fillable = [
        'name',
    ];

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
     * Водители, закрепленные за автомобилем.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(MoonshineUser::class, 'truck_user', 'truck_id', 'user_id');
    }

    /**
     * Получить данные о заправках автомобиля.
     */
    public function truckRefillings(): HasMany
    {
        return $this->hasMany(Refilling::class, 'truck_id', 'id');
    }
}

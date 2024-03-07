<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use MoonShine\Models\MoonshineUser;

class Truck extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'brand_id',
    // ];

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
}

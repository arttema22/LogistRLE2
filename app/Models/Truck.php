<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
}

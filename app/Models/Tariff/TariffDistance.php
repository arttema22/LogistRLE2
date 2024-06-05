<?php

namespace App\Models\Tariff;

use App\Models\Dir\DirTruckType;
use Illuminate\Database\Eloquent\Model;
use MoonShine\ChangeLog\Traits\HasChangeLog;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TariffDistance extends Model
{
    use HasFactory, HasChangeLog;

    protected $fillable = [
        '0_15',
        '16_30',
        '31_60',
        '60_300',
        '300_00',
        'truck_type_id'
    ];

    /**
     * truckType
     *
     * @return BelongsTo
     * Получить тип авто
     */
    public function truckType(): BelongsTo
    {
        return $this->belongsTo(DirTruckType::class, 'truck_type_id');
    }
}

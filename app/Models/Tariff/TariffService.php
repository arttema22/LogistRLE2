<?php

namespace App\Models\Tariff;

use App\Models\Dir\DirService;
use Illuminate\Database\Eloquent\Model;
use MoonShine\ChangeLog\Traits\HasChangeLog;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TariffService extends Model
{
    use HasFactory, HasChangeLog;

    protected $fillable = [
        'service_id', 'price'
    ];

    /**
     * service
     * Получить название сервиса.
     * @return BelongsTo
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(DirService::class, 'service_id');
    }
}

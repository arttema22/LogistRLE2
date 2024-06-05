<?php

namespace App\Models\Tariff;

use App\Models\Dir\DirRouteAddress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use MoonShine\ChangeLog\Traits\HasChangeLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TariffRoute extends Model
{
    use HasFactory, SoftDeletes, HasChangeLog, MassPrunable;

    /**
     * start
     *
     * @return BelongsTo
     * Получить адрес старта
     */
    public function start(): BelongsTo
    {
        return $this->belongsTo(DirRouteAddress::class, 'start_id');
    }

    /**
     * finish
     *
     * @return BelongsTo
     * Получить адрес финиша
     */
    public function finish(): BelongsTo
    {
        return $this->belongsTo(DirRouteAddress::class, 'finish_id');
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

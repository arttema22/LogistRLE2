<?php

namespace App\Models;

use App\Models\Sys\MoonshineUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use MoonShine\ChangeLog\Traits\HasChangeLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusinessTrip extends Model
{
    use HasFactory, SoftDeletes, HasChangeLog, MassPrunable;

    protected $fillable = [
        'date',
        'owner_id',
        'driver_id',
        'sum',
        'comment',
        'profit_id',
    ];

    /**
     * owner
     * Получить данные о создателе записи.
     * @return void
     */
    public function owner()
    {
        return $this->belongsTo(MoonshineUser::class, 'owner_id', 'id');
    }

    /**
     * driver
     * Получить данные о водителе.
     * @return void
     */
    public function driver()
    {
        return $this->belongsTo(MoonshineUser::class, 'driver_id', 'id');
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

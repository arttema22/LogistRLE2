<?php

namespace App\Models;

use App\Models\Dir\DirCargo;
use App\Models\Sys\MoonshineUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use MoonShine\ChangeLog\Traits\HasChangeLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Route extends Model
{
    use HasFactory, SoftDeletes, HasChangeLog, MassPrunable;

    protected $fillable = [
        'date',
        'owner_id',
        'driver_id',
        'unexpected_expenses'
    ];

    /**
     * Получить данные о создателе записи.
     */
    public function owner()
    {
        return $this->belongsTo(MoonshineUser::class, 'owner_id', 'id');
    }

    /**
     * Получить данные о водителе.
     */
    public function driver()
    {
        return $this->belongsTo(MoonshineUser::class, 'driver_id', 'id');
    }

    /**
     * Получить данные о водителе.
     */
    public function cargo()
    {
        return $this->belongsTo(DirCargo::class, 'cargo_id', 'id');
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

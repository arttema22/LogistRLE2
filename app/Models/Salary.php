<?php

namespace App\Models;

use MoonShine\Models\MoonshineUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use MoonShine\ChangeLog\Traits\HasChangeLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Salary extends Model
{
    use HasFactory, SoftDeletes, HasChangeLog, MassPrunable;

    protected $fillable = [
        'date',
        'owner_id',
        'driver_id',
        'salary',
        'profit_id',
        'comment',
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
     * Запрос для удаления устаревших записей модели.
     */
    public function prunable(): Builder
    {
        return static::where('deleted_at', '<=', now()->subDay());
    }
}

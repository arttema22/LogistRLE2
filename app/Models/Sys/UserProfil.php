<?php

namespace App\Models\Sys;

use Illuminate\Database\Eloquent\Model;
use MoonShine\ChangeLog\Traits\HasChangeLog;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserProfil extends Model
{
    use HasFactory, HasChangeLog;

    protected $fillable = [
        'driver_id', 'surname', 'name', 'patronymic',
        'phone', 'e1_card'
    ];

    /**
     * user
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(MoonshineUser::class, 'driver_id');
    }
}

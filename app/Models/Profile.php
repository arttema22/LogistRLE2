<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use MoonShine\Models\MoonshineUser;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    /**
     * Получить пользователя профиля.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(MoonshineUser::class, 'user_id');
    }
}

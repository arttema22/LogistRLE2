<?php

declare(strict_types=1);

namespace App\Models\Sys;

use Illuminate\Notifications\Notifiable;
use MoonShine\ChangeLog\Traits\HasChangeLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MoonShine\Database\Factories\MoonshineUserFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class MoonshineUser extends Authenticatable
{
    //    use HasMoonShineSocialite;
    use HasFactory;
    use Notifiable;
    use HasChangeLog, MassPrunable;

    protected $fillable = [
        'email',
        'moonshine_user_role_id',
        'password',
        'name',
        'avatar',
    ];

    protected static function newFactory(): Factory
    {
        return MoonshineUserFactory::new();
    }

    public function isSuperUser(): bool
    {
        return $this->moonshine_user_role_id === MoonshineUserRole::DEFAULT_ROLE_ID;
    }

    public function moonshineUserRole(): BelongsTo
    {
        return $this->belongsTo(MoonshineUserRole::class);
    }
}

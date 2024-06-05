<?php

declare(strict_types=1);

namespace App\Models\Sys;

use MoonShine\Models\MoonshineUser;
use Illuminate\Database\Eloquent\Model;
use MoonShine\ChangeLog\Traits\HasChangeLog;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string $name
 */
class MoonshineUserRole extends Model
{
    use HasFactory, HasChangeLog;

    final public const DEFAULT_ROLE_ID = 1;

    protected $fillable = ['name'];

    public function moonshineUsers(): HasMany
    {
        return $this->hasMany(MoonshineUser::class);
    }
}

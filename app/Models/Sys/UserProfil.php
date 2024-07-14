<?php

namespace App\Models\Sys;

use Illuminate\Database\Eloquent\Model;
use MoonShine\ChangeLog\Traits\HasChangeLog;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserProfil extends Model
{
    use HasFactory, HasChangeLog;

    protected $fillable = [
        'driver_id', 'surname', 'name', 'patronymic',
        'phone', 'e1_card', 'f1с_ref_key', 'f1с_contract',
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

    /**
     * surname
     *
     * @return Attribute
     */
    protected function surname(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => ucfirst(strtolower($value)),
        );
    }

    /**
     * name
     *
     * @return Attribute
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => ucfirst(strtolower($value)),
        );
    }

    /**
     * patronymic
     *
     * @return Attribute
     */
    protected function patronymic(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => ucfirst(strtolower($value)),
        );
    }

    /**
     * phone
     * не работает
     * @return Attribute
     */
    // protected function phone(): Attribute
    // {
    //     return Attribute::make(
    //         set: fn (string $value) => preg_replace('/[^0-9]/', '', $value),
    //     );
    // }

    /**
     * e1_card
     *
     * @return Attribute
     */
    protected function e1_card(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => preg_replace('/[^0-9]/', '', $value),
        );
    }
}

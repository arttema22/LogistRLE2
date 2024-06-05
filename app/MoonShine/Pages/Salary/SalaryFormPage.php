<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Salary;

use MoonShine\Fields\Date;
use MoonShine\Fields\Text;
use MoonShine\Fields\Field;
use MoonShine\Fields\Number;
use MoonShine\Decorations\Flex;
use MoonShine\Decorations\Block;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\MoonShine\Pages\Crud\FormPageCustom;
use MoonShine\Fields\Relationships\BelongsTo;
use App\MoonShine\Resources\Sys\MoonShineUserResource;

class SalaryFormPage extends FormPageCustom
{
    /**
     * getAlias
     *
     * @return string
     */
    public function getAlias(): ?string
    {
        return __('moonshine::salary.form_page');
    }

    /**
     * fields
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Block::make([
                BelongsTo::make('driver', 'driver', resource: new MoonShineUserResource())
                    ->valuesQuery(fn (Builder $query, Field $field) => $query->where('moonshine_user_role_id', 3))
                    ->required()
                    ->nullable()
                    ->translatable('moonshine::ui')
                    ->when(
                        fn () => Auth::user()->moonshine_user_role_id == 3,
                        fn (Field $field) => $field->hideOnForm(),
                    ),
                Flex::make([
                    Date::make('date')->required()
                        ->translatable('moonshine::ui'),
                    Number::make('sum')->required()
                        ->min(10)->max(9999999.99)->step(0.01)
                        ->translatable('moonshine::ui'),
                ]),
                Text::make('comment')->translatable('moonshine::ui'),
            ]),
        ];
    }
}

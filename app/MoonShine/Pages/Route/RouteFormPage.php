<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Route;

use MoonShine\Fields\Date;
use MoonShine\Fields\Text;
use MoonShine\Fields\Field;
use MoonShine\Fields\Number;
use MoonShine\Decorations\Grid;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\MoonShine\Pages\Crud\FormPageCustom;
use MoonShine\Fields\Relationships\BelongsTo;
use App\MoonShine\Resources\Dir\DirCargoResource;
use App\MoonShine\Resources\Sys\MoonShineUserResource;

class RouteFormPage extends FormPageCustom
{
    public function getAlias(): ?string
    {
        return __('moonshine::route.form_page');
    }

    public function fields(): array
    {
        return [
            Grid::make([
                Column::make([
                    BelongsTo::make('driver', 'driver', resource: new MoonShineUserResource())
                        ->valuesQuery(fn (Builder $query, Field $field) => $query->where('moonshine_user_role_id', 3))
                        ->required()
                        ->nullable()
                        ->searchable()
                        ->translatable('moonshine::route')
                        ->when(
                            fn () => Auth::user()->moonshine_user_role_id == 3,
                            fn (Field $field) => $field->hideOnForm(),
                        ),
                ])->columnSpan(12),

                Column::make([
                    Block::make([
                        Date::make('date')->required()
                            ->translatable('moonshine::route'),

                        BelongsTo::make('cargo', 'cargo', resource: new DirCargoResource())
                            ->required()
                            ->nullable()
                            ->searchable()
                            ->translatable('moonshine::route'),
                        Text::make('address_loading'),
                        Text::make('address_unloading'),
                        Number::make('number_trips'),
                        Number::make('unexpected_expenses'),
                    ]),
                ])->columnSpan(6),
            ]),
        ];
    }
}

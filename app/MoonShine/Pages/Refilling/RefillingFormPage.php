<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Refilling;

use App\MoonShine\Pages\Crud\FormPageCustom;
use App\MoonShine\Resources\DirFuelTypeResource;
use MoonShine\Fields\Date;
use MoonShine\Fields\Text;
use MoonShine\Fields\Field;
use MoonShine\Fields\Number;
use MoonShine\Decorations\Grid;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\MoonShine\Resources\TruckResource;
use MoonShine\Fields\Relationships\BelongsTo;
use App\MoonShine\Resources\MoonShineUserResource;
use App\MoonShine\Resources\DirPetrolStationResource;

class RefillingFormPage extends FormPageCustom
{
    public function getAlias(): ?string
    {
        return __('moonshine::refilling.form_page');
    }

    public function fields(): array
    {
        return [
            Grid::make([
                Column::make([
                    Block::make([
                        BelongsTo::make('driver', 'driver', resource: new MoonShineUserResource())
                            ->valuesQuery(fn (Builder $query, Field $field) => $query->where('moonshine_user_role_id', 3))
                            ->required()
                            ->nullable()
                            ->translatable('moonshine::refilling')
                            ->when(
                                fn () => Auth::user()->moonshine_user_role_id == 3,
                                fn (Field $field) => $field->hideOnForm(),
                            ),
                        BelongsTo::make(
                            'petrol_station',
                            'petrolStation',
                            fn ($item) => $item->petrolStationBrand->name . ' | ' . $item->address,
                            resource: new DirPetrolStationResource()
                        )
                            ->required()
                            ->nullable()
                            ->searchable()
                            ->translatable('moonshine::refilling'),
                        BelongsTo::make(
                            'fuel',
                            'fuelType',
                            fn ($item) => $item->fuelCategory->name . ' | ' . $item->name,
                            resource: new DirFuelTypeResource()
                        )
                            ->required()
                            ->nullable()
                            ->searchable()
                            ->translatable('moonshine::refilling'),
                        Date::make('date')->required()->withTime()
                            ->translatable('moonshine::refilling'),
                        Number::make('volume')->required()
                            ->min(10)->max(9999999.99)->step(0.01)
                            ->translatable('moonshine::refilling'),

                        Number::make('price')->required()
                            ->min(10)->max(9999999.99)->step(0.01)
                            ->translatable('moonshine::refilling'),

                        Number::make('sum')->required()
                            ->min(10)->max(9999999.99)->step(0.01)
                            ->translatable('moonshine::refilling'),
                    ]),
                ])->columnSpan(6),
                Column::make([
                    Block::make([
                        BelongsTo::make(
                            'truck',
                            'truck',
                            fn ($item) => "$item->name \ $item->reg_num_ru",
                            resource: new TruckResource()
                        )->searchable()
                            ->nullable()
                            ->translatable('moonshine::refilling'),
                        Text::make('comment')->translatable('moonshine::refilling'),
                    ]),
                ])->columnSpan(6),
            ]),
        ];
    }

    protected function topLayer(): array
    {
        return [
            ...parent::topLayer()
        ];
    }

    protected function mainLayer(): array
    {
        return [
            ...parent::mainLayer()
        ];
    }

    protected function bottomLayer(): array
    {
        return [
            ...parent::bottomLayer()
        ];
    }
}

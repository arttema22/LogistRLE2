<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Refilling;

use MoonShine\Fields\Date;
use MoonShine\Fields\Text;
use MoonShine\Fields\Field;
use MoonShine\Fields\Fields;
use MoonShine\Fields\Textarea;
use MoonShine\Decorations\Flex;
use MoonShine\Decorations\Grid;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\MoonShine\Pages\Crud\FormPageCustom;
use MoonShine\Fields\Relationships\BelongsTo;
use App\MoonShine\Resources\Sys\TruckResource;
use App\MoonShine\Resources\Dir\DirFuelTypeResource;
use App\MoonShine\Resources\Sys\MoonShineUserResource;
use App\MoonShine\Resources\Dir\DirFuelCategoryResource;
use App\MoonShine\Resources\Dir\DirPetrolStationBrandResource;
use App\MoonShine\Resources\Dir\DirPetrolStationResource;

class RefillingFormPage extends FormPageCustom
{
    /**
     * getAlias
     *
     * @return string
     */
    public function getAlias(): ?string
    {
        return __('moonshine::refilling.form_page');
    }

    /**
     * fields
     *
     * @return array
     */
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
                        ->translatable('moonshine::refilling')
                        ->when(
                            fn () => Auth::user()->moonshine_user_role_id == 3,
                            fn (Field $field) => $field->hideOnForm(),
                        ),
                ])->columnSpan(12),

                Column::make([
                    Block::make([
                        Date::make('date')->required()
                            ->translatable('moonshine::refilling'),
                        Flex::make([
                            Text::make('volume')->required()
                                ->reactive(
                                    function (Fields $fields, ?string $value): Fields {
                                        return tap(
                                            $fields,
                                            static fn ($fields) => $fields
                                                ->findByColumn('sum')
                                                ?->setValue($value * $fields->findByColumn('price')->value())
                                        );
                                    }
                                )
                                ->translatable('moonshine::refilling'),

                            Text::make('price')->required()
                                ->reactive()
                                ->translatable('moonshine::refilling'),

                            Text::make('sum')
                                ->reactive()
                                ->readonly()
                                ->translatable('moonshine::refilling'),
                        ]),
                    ]),
                ])->columnSpan(6),

                Column::make([
                    Block::make([
                        Flex::make([
                            BelongsTo::make(
                                'stantion',
                                'petrolBrand',
                                resource: new DirPetrolStationBrandResource()
                            )
                                ->nullable()
                                ->searchable()
                                ->translatable('moonshine::refilling'),
                            BelongsTo::make(
                                'address',
                                'petrolStation',
                                resource: new DirPetrolStationResource()
                            )
                                ->associatedWith('dir_petrol_station_brand_id')
                                ->nullable()
                                ->searchable()
                                ->translatable('moonshine::refilling'),
                        ]),
                        Flex::make([
                            BelongsTo::make(
                                'fuel',
                                'fuelCategory',
                                resource: new DirFuelCategoryResource()
                            )
                                ->nullable()
                                ->searchable()
                                ->translatable('moonshine::refilling'),

                            BelongsTo::make(
                                'fuel_type',
                                'fuelType',
                                resource: new DirFuelTypeResource()
                            )
                                ->associatedWith('dir_fuel_category_id')
                                ->nullable()
                                ->searchable()
                                ->translatable('moonshine::refilling'),
                        ]),
                        BelongsTo::make(
                            'truck',
                            'truck',
                            fn ($item) => "$item->name \ $item->reg_num_ru",
                            resource: new TruckResource()
                        )
                            ->associatedWith('driver_id')
                            ->searchable()
                            ->nullable()
                            ->translatable('moonshine::refilling'),
                    ]),
                ])->columnSpan(6),

                Column::make([
                    Block::make([
                        Textarea::make('comment')->translatable('moonshine::refilling'),
                    ]),
                ])->columnSpan(12),
            ]),
        ];
    }
}

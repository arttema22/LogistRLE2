<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Dir\DirFuelType;

use MoonShine\Fields\Text;
use MoonShine\Decorations\Grid;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use Illuminate\Database\Eloquent\Builder;
use App\MoonShine\Pages\Crud\FormPageCustom;
use MoonShine\Fields\Relationships\BelongsTo;
use App\MoonShine\Resources\Dir\DirFuelCategoryResource;

class DirFuelTypeFormPage extends FormPageCustom
{
    /**
     * getAlias
     * Устанавливает алиас для ресурса.
     * @return string
     */
    public function getAlias(): ?string
    {
        return __('moonshine::directory.resource_form');
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
                Text::make('name')->required()->translatable('moonshine::ui'),
                BelongsTo::make('fuel_category', 'fuelCategory', resource: new DirFuelCategoryResource())
                    ->valuesQuery(fn (Builder $query) => $query->whereNull('deleted_at'))
                    ->required()
                    ->searchable()
                    ->nullable()
                    ->translatable('moonshine::directory'),
            ]),
        ];
    }

    /**
     * mainLayer
     *
     * @return array
     */
    protected function mainLayer(): array
    {
        return [
            Grid::make([
                Column::make([
                    Block::make([
                        ...parent::mainLayer()
                    ]),
                ])->columnSpan(6),
                Column::make([])->columnSpan(6),
            ]),
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Dir\DirFuelType;

use MoonShine\Fields\Text;
use MoonShine\Decorations\Block;
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
                Text::make('name')->required()->translatable('moonshine::directory'),
                BelongsTo::make('fuel_category', 'fuelCategory', resource: new DirFuelCategoryResource())
                    ->required()
                    ->searchable()
                    ->nullable()
                    ->translatable('moonshine::directory'),
            ]),
        ];
    }
}

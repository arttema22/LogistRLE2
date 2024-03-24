<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Dir\DirFuelType;

use MoonShine\Fields\Text;
use MoonShine\Fields\Position;
use MoonShine\Pages\Crud\IndexPage;
use MoonShine\Fields\Relationships\BelongsTo;
use App\MoonShine\Resources\Dir\DirFuelCategoryResource;

class DirFuelTypeIndexPage extends IndexPage
{
    /**
     * getAlias
     * Устанавливает алиас для ресурса.
     * @return string
     */
    public function getAlias(): ?string
    {
        return __('moonshine::directory.resource_list');
    }

    /**
     * fields
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Position::make(),
            Text::make('name')->sortable()->translatable('moonshine::directory'),
            BelongsTo::make('fuel_category', 'fuelCategory', resource: new DirFuelCategoryResource())
                ->translatable('moonshine::directory'),
        ];
    }
}

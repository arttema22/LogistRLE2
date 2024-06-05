<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Dir\DirPetrolStation;

use MoonShine\Fields\Text;
use MoonShine\Fields\Position;
use MoonShine\Decorations\Grid;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Heading;
use MoonShine\Pages\Crud\IndexPage;
use MoonShine\Fields\Relationships\BelongsTo;
use App\MoonShine\Resources\Dir\DirPetrolStationBrandResource;

class DirPetrolStationIndexPage extends IndexPage
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
            Text::make('address')->sortable()->translatable('moonshine::directory'),
            Text::make('brand', 'petrolStationBrand.name')->translatable('moonshine::directory'),
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
                Column::make([
                    Heading::make(''),
                ])->columnSpan(6),
            ]),
        ];
    }
}

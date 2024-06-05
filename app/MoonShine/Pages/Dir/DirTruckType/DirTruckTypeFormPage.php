<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Dir\DirTruckType;

use MoonShine\Fields\Text;
use MoonShine\Decorations\Grid;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use App\MoonShine\Pages\Crud\FormPageCustom;

class DirTruckTypeFormPage extends FormPageCustom
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
                Text::make('name')
                    ->required()
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

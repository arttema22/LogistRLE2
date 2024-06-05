<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Dir\DirFuelCategory;

use MoonShine\Fields\Text;
use MoonShine\Decorations\Grid;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Heading;
use App\MoonShine\Pages\Crud\FormPageCustom;
use MoonShine\ChangeLog\Components\ChangeLog;

class DirFuelCategoryFormPage extends FormPageCustom
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

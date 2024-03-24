<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Dir\DirService;

use MoonShine\Fields\Text;
use MoonShine\Fields\Number;
use MoonShine\Decorations\Block;
use App\MoonShine\Pages\Crud\FormPageCustom;

class DirServiceFormPage extends FormPageCustom
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
                Number::make('price')->required()
                    ->min(9)->max(999999.99)->step(0.01)
                    ->translatable('moonshine::directory'),
            ]),
        ];
    }
}

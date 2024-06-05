<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Tariff\TariffService;

use MoonShine\Fields\Number;
use MoonShine\Decorations\Block;
use App\MoonShine\Pages\Crud\FormPageCustom;

class TariffServiceFormPage extends FormPageCustom
{
    /**
     * getAlias
     * Устанавливает алиас для ресурса.
     * @return string
     */
    public function getAlias(): ?string
    {
        return __('moonshine::tariff.resource_form');
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
                Number::make('price')->required()
                    ->min(9)->max(999999.99)->step(0.01)
                    ->translatable('moonshine::ui'),
            ]),
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Tariff\TariffDistance;

use MoonShine\Fields\Text;
use MoonShine\Fields\Number;
use MoonShine\Decorations\Flex;
use MoonShine\Decorations\Block;
use MoonShine\Components\Layout\Header;
use App\MoonShine\Pages\Crud\FormPageCustom;

class TariffDistanceFormPage extends FormPageCustom
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
                Flex::make([
                    Number::make('0_15')->step(.01)->expansion('руб.')->translatable('moonshine::tariff'),
                    Number::make('16_30')->step(.01)->expansion('руб.')->translatable('moonshine::tariff'),
                    Number::make('31_60')->step(.01)->expansion('руб.')->translatable('moonshine::tariff'),
                    Number::make('60_300')->step(.01)->expansion('руб.')->translatable('moonshine::tariff'),
                    Number::make('300_00')->step(.01)->expansion('руб.')->translatable('moonshine::tariff'),
                ]),
            ]),
        ];
    }
}

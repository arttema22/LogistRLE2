<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Tariff\TariffRoute;

use MoonShine\Fields\Text;
use MoonShine\Fields\Position;
use MoonShine\Pages\Crud\IndexPage;

class TariffRouteIndexPage extends IndexPage
{
    /**
     * getAlias
     * Устанавливает алиас для ресурса.
     * @return string
     */
    public function getAlias(): ?string
    {
        return __('moonshine::tariff.resource_list');
    }

    public function fields(): array
    {
        return [
            Position::make(),
            Text::make('start', 'start.name')->translatable('moonshine::tariff'),
            Text::make('finish', 'finish.name')->translatable('moonshine::tariff'),
            Text::make('length')->translatable('moonshine::tariff'),
            Text::make('price')->badge('primary')->translatable('moonshine::tariff'),
        ];
    }
}

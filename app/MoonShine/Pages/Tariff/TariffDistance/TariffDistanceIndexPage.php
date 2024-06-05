<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Tariff\TariffDistance;

use MoonShine\Fields\Text;
use MoonShine\Fields\Number;
use MoonShine\Fields\Position;
use MoonShine\Pages\Crud\IndexPage;

class TariffDistanceIndexPage extends IndexPage
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

    /**
     * fields
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Position::make(),
            Text::make('type', 'truckType.name')->translatable('moonshine::tariff'),
            Number::make('0_15')->badge('primary')->sortable()->translatable('moonshine::tariff'),
            Number::make('16_30')->badge('primary')->sortable()->translatable('moonshine::tariff'),
            Number::make('31_60')->badge('primary')->sortable()->translatable('moonshine::tariff'),
            Number::make('60_300')->badge('primary')->sortable()->translatable('moonshine::tariff'),
            Number::make('300_00')->badge('primary')->sortable()->translatable('moonshine::tariff'),
        ];
    }
}

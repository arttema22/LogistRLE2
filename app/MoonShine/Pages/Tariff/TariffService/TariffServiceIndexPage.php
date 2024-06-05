<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Tariff\TariffService;

use MoonShine\Fields\Text;
use MoonShine\Fields\Position;
use MoonShine\Pages\Crud\IndexPage;

class TariffServiceIndexPage extends IndexPage
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
            Text::make('name', 'service.name')->translatable('moonshine::ui'),
            Text::make('price')->badge('primary')->sortable()
                ->translatable('moonshine::ui'),
        ];
    }
}

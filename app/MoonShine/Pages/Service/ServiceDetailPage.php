<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Service;

use MoonShine\Fields\Date;
use MoonShine\Fields\Text;
use MoonShine\Fields\Textarea;
use MoonShine\Pages\Crud\DetailPage;

class ServiceDetailPage extends DetailPage
{
    /**
     * getAlias
     *
     * @return string
     */
    public function getAlias(): ?string
    {
        return __('moonshine::service.detail_page');
    }

    /**
     * fields
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Date::make('date')->format('d.m.Y')->translatable('moonshine::ui'),
            Text::make('driver.name')->translatable('moonshine::ui'),
            Text::make('name', 'service.name')->translatable('moonshine::ui'),
            Text::make('price', 'service.tariff.price')->translatable('moonshine::ui'),
            Textarea::make('comment')->translatable('moonshine::ui'),
        ];
    }
}

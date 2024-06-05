<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\BusinessTrip;

use MoonShine\Fields\Date;
use MoonShine\Fields\Text;
use MoonShine\Pages\Crud\DetailPage;

class BusinessTripDetailPage extends DetailPage
{
    /**
     * getAlias
     *
     * @return string
     */
    public function getAlias(): ?string
    {
        return __('moonshine::business.detail_page');
    }

    /**
     * fields
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Date::make('date')->format('d.m.Y')->translatable('moonshine::business'),
            Text::make('driver.name')->translatable('moonshine::business'),
            Text::make('sum')->translatable('moonshine::business'),
            Text::make('comment')->translatable('moonshine::business'),
        ];
    }
}

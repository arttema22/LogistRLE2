<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Salary;

use MoonShine\Fields\Date;
use MoonShine\Fields\Text;
use MoonShine\Pages\Crud\DetailPage;

class SalaryDetailPage extends DetailPage
{
    /**
     * getAlias
     *
     * @return string
     */
    public function getAlias(): ?string
    {
        return __('moonshine::salary.detail_page');
    }

    /**
     * fields
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Date::make('date')->format('d.m.Y')->translatable('moonshine::salary'),
            Text::make('driver.name')->translatable('moonshine::salary'),
            Text::make('sum')->translatable('moonshine::salary'),
            Text::make('comment')->translatable('moonshine::salary'),
        ];
    }
}

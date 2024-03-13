<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Salary;

use MoonShine\Fields\Date;
use MoonShine\Fields\Text;
use MoonShine\Fields\Number;
use MoonShine\Pages\Crud\DetailPage;
use MoonShine\Fields\Relationships\BelongsTo;
use App\MoonShine\Resources\MoonShineUserResource;

class SalaryDetailPage extends DetailPage
{
    public function getAlias(): ?string
    {
        return __('moonshine::salary.detail_page');
    }

    public function fields(): array
    {
        return [
            Date::make('date')->format('d.m.Y')->translatable('moonshine::salary'),
            Number::make('salary')->translatable('moonshine::salary'),
            BelongsTo::make('driver', 'driver', resource: new MoonShineUserResource())
                ->translatable('moonshine::salary'),
            Text::make('comment')->translatable('moonshine::salary'),

            Date::make('created_at')->format('d.m.Y H:i')->translatable('moonshine::salary'),
            Date::make('updated_at')->format('d.m.Y H:i')->translatable('moonshine::salary'),
            BelongsTo::make('owner', 'owner', resource: new MoonShineUserResource())
                ->translatable('moonshine::salary'),
            Text::make('profit_id')->translatable('moonshine::salary'),
        ];
    }

    protected function topLayer(): array
    {
        return [
            ...parent::topLayer()
        ];
    }

    protected function mainLayer(): array
    {
        return [
            ...parent::mainLayer()
        ];
    }

    protected function bottomLayer(): array
    {
        return [
            ...parent::bottomLayer()
        ];
    }
}

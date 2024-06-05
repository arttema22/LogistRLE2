<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Refilling;

use MoonShine\Fields\Date;
use MoonShine\Fields\Text;
use MoonShine\Fields\Number;
use MoonShine\Pages\Crud\DetailPage;
use MoonShine\Fields\Relationships\BelongsTo;
use App\MoonShine\Resources\Sys\MoonShineUserResource;

class RefillingDetailPage extends DetailPage
{
    public function getAlias(): ?string
    {
        return __('moonshine::refilling.detail_page');
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
}

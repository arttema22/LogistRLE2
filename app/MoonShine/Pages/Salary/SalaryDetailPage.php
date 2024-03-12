<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Salary;

use MoonShine\Fields\Date;
use MoonShine\Fields\Text;
use MoonShine\Fields\Field;
use MoonShine\Fields\Number;
use MoonShine\Fields\Preview;
use MoonShine\Fields\Textarea;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Divider;
use Illuminate\Support\Facades\Auth;
use MoonShine\Pages\Crud\DetailPage;
use Illuminate\Database\Eloquent\Builder;
use MoonShine\Fields\Relationships\BelongsTo;
use App\MoonShine\Resources\MoonShineUserResource;

class SalaryDetailPage extends DetailPage
{
    public function fields(): array
    {
        return [
            Date::make('date')->translatable('moonshine::salary'),
            Number::make('salary')->translatable('moonshine::salary'),
            BelongsTo::make('driver', 'driver', resource: new MoonShineUserResource())
                ->translatable('moonshine::salary'),
            Textarea::make('comment')->translatable('moonshine::salary'),

            Preview::make('help')
                ->link('https://github.com/arttema22/LogistRLE2/wiki/%D0%92%D1%8B%D0%BF%D0%BB%D0%B0%D1%82%D1%8B', __('moonshine::ui.help'), blank: true)
                ->translatable('moonshine::ui'),
            Date::make('created_at'),
            Date::make('updated_at'),
            BelongsTo::make('owner', 'owner', resource: new MoonShineUserResource())
                ->translatable('moonshine::salary'),
            Text::make('profit_id'),
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

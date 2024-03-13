<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Salary;

use MoonShine\Fields\Date;
use MoonShine\Fields\Text;
use MoonShine\Fields\Field;
use MoonShine\Fields\Preview;
use MoonShine\Fields\Position;
use MoonShine\Components\Modal;
use MoonShine\Components\Offcanvas;
use MoonShine\Pages\Crud\IndexPage;
use Illuminate\Support\Facades\Auth;
use MoonShine\Components\FormBuilder;
use MoonShine\ActionButtons\ActionButton;
use MoonShine\Fields\Relationships\BelongsTo;
use App\MoonShine\Resources\MoonShineUserResource;

class SalaryIndexPage extends IndexPage
{
    public function getAlias(): ?string
    {
        return __('moonshine::salary.index_page');
    }

    public function fields(): array
    {
        return [
            Position::make(),
            Date::make('date')->format('d.m.Y')->sortable()
                ->translatable('moonshine::salary'),
            BelongsTo::make('driver', 'driver', resource: new MoonShineUserResource())
                ->sortable()
                ->when(
                    Auth::user()->moonshine_user_role_id === 3,
                    fn (Field $field) => $field->hideOnIndex()
                )
                ->translatable('moonshine::salary'),
            Text::make('salary')
                ->translatable('moonshine::salary'),
            Text::make('comment')->translatable('moonshine::salary'),
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
            ...parent::mainLayer(),
        ];
    }

    protected function bottomLayer(): array
    {
        return [
            ...parent::bottomLayer(),
            ActionButton::make(
                __('moonshine::ui.help'),
                'https://github.com/arttema22/LogistRLE2/wiki/%D0%92%D1%8B%D0%BF%D0%BB%D0%B0%D1%82%D1%8B'
            )->blank()
                ->icon('heroicons.outline.information-circle')
                ->warning(),
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Salary;

use MoonShine\Fields\Date;
use MoonShine\Fields\Field;
use MoonShine\Fields\Number;
use MoonShine\Fields\Preview;
use MoonShine\Fields\Textarea;
use MoonShine\Decorations\Block;
use MoonShine\Pages\Crud\FormPage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use MoonShine\Fields\Relationships\BelongsTo;
use App\MoonShine\Resources\MoonShineUserResource;

class SalaryFormPage extends FormPage
{
    public function fields(): array
    {
        return [
            Preview::make()
                ->link('https://github.com/arttema22/LogistRLE2/wiki/%D0%92%D1%8B%D0%BF%D0%BB%D0%B0%D1%82%D1%8B', __('moonshine::ui.help'), blank: true),
            Block::make([
                Date::make('date')->required()
                    ->translatable('moonshine::salary'),
                BelongsTo::make('driver', 'driver', resource: new MoonShineUserResource())
                    ->valuesQuery(fn (Builder $query, Field $field) => $query->where('moonshine_user_role_id', 3))
                    ->required()
                    ->nullable()
                    ->translatable('moonshine::salary')
                    ->when(
                        Auth::user()->moonshine_user_role_id === 3,
                        fn (Field $field) => $field->hideOnForm(),
                    ),
                Number::make('salary')->required()
                    ->min(10)->max(9999999.99)->step(0.01)
                    ->translatable('moonshine::salary'),
                Textarea::make('comment')->translatable('moonshine::salary'),
            ]),
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

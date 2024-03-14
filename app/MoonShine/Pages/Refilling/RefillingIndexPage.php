<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Refilling;

use MoonShine\Fields\Date;
use MoonShine\Fields\Text;
use MoonShine\Fields\Field;
use MoonShine\Fields\Position;
use MoonShine\Pages\Crud\IndexPage;
use Illuminate\Support\Facades\Auth;
use MoonShine\ActionButtons\ActionButton;
use MoonShine\Fields\Relationships\BelongsTo;
use App\MoonShine\Resources\MoonShineUserResource;
use App\MoonShine\Resources\DirPetrolStationResource;

class RefillingIndexPage extends IndexPage
{
    public function getAlias(): ?string
    {
        return __('moonshine::refilling.index_page');
    }

    public function fields(): array
    {
        return [
            Position::make(),
            Date::make('date')->format('d.m.Y')->sortable()
                ->translatable('moonshine::refilling'),
            BelongsTo::make('driver', 'driver', resource: new MoonShineUserResource())
                ->sortable()
                ->when(
                    Auth::user()->moonshine_user_role_id == 3,
                    fn (Field $field) => $field->hideOnIndex()
                )
                ->translatable('moonshine::refilling'),
            Text::make('num_liters_car_refueling')->badge('primary')
                ->sortable()
                ->translatable('moonshine::refilling'),
            Text::make('price_car_refueling')->translatable('moonshine::refilling'),
            Text::make('cost_car_refueling')
                ->sortable()
                ->translatable('moonshine::refilling'),
            BelongsTo::make(
                'stantion',
                'petrolStation',
                function ($item) {
                    $test = $item->petrolStationBrand->name;
                    return $test . '<br>' . $item->address;
                },
                resource: new DirPetrolStationResource()
            )->translatable('moonshine::refilling'),
            BelongsTo::make(
                'truck',
                'truck',
                fn ($item) => "$item->name<br>$item->reg_num",
                resource: new DirPetrolStationResource()
            )->translatable('moonshine::refilling'),
            Text::make('comment')->translatable('moonshine::refilling'),
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
            ...parent::bottomLayer(),
            ActionButton::make(
                __('moonshine::ui.help'),
                'https://github.com/arttema22/LogistRLE2/wiki/%D0%97%D0%B0%D0%BF%D1%80%D0%B0%D0%B2%D0%BA%D0%B8'
            )->blank()
                ->icon('heroicons.outline.lifebuoy'),
        ];
    }
}

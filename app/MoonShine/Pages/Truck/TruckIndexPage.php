<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Truck;

use MoonShine\Fields\Text;
use MoonShine\Fields\Position;
use MoonShine\Fields\StackFields;
use MoonShine\Pages\Crud\IndexPage;
use MoonShine\Fields\Relationships\BelongsTo;
use App\MoonShine\Resources\DirTruckTypeResource;
use MoonShine\Fields\Relationships\BelongsToMany;
use App\MoonShine\Resources\DirTruckBrandResource;
use App\MoonShine\Resources\MoonShineUserResource;

class TruckIndexPage extends IndexPage
{
    public function fields(): array
    {
        return [
            Position::make(),
            StackFields::make('reg_num')->fields([
                Text::make('reg_num_ru'),
                Text::make('reg_num_en'),
            ])->translatable('moonshine::truck'),
            StackFields::make('truck')->fields([
                Text::make('name')->translatable('moonshine::truck'),
                BelongsTo::make('brand', 'brand', resource: new DirTruckBrandResource())
                    ->translatable('moonshine::directory'),
            ])->translatable('moonshine::truck'),
            BelongsTo::make('type', 'type', resource: new DirTruckTypeResource())
                ->sortable()
                ->translatable('moonshine::directory'),
            BelongsToMany::make('driver', 'users', resource: new MoonShineUserResource())
                ->inLine(separator: ', ')
                ->translatable('moonshine::truck'),
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

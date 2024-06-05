<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Sys\Truck;

use MoonShine\Fields\Text;
use MoonShine\Fields\Position;
use MoonShine\Fields\StackFields;
use MoonShine\Pages\Crud\IndexPage;
use MoonShine\Fields\Relationships\BelongsTo;
use App\MoonShine\Resources\Sys\MoonShineUserResource;

class TruckIndexPage extends IndexPage
{
    /**
     * getAlias
     * Устанавливает алиас для ресурса.
     * @return string
     */
    public function getAlias(): ?string
    {
        return __('moonshine::system.resource_list');
    }

    /**
     * fields
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Position::make(),
            StackFields::make('reg_num')->fields([
                Text::make('reg_num_ru'),
                Text::make('reg_num_en'),
            ])->translatable('moonshine::system.truck'),
            StackFields::make('truck')->fields([
                Text::make('name'),
                Text::make('brand.name'),
            ])->translatable('moonshine::system.truck'),
            Text::make('type', 'type.name')->translatable('moonshine::system.truck'),
            BelongsTo::make('driver', 'driver', resource: new MoonShineUserResource())
                ->translatable('moonshine::system.truck'),
        ];
    }
}

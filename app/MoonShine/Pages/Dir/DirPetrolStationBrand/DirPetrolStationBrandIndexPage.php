<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Dir\DirPetrolStationBrand;

use MoonShine\Fields\Text;
use MoonShine\Fields\Field;
use MoonShine\Fields\Position;
use MoonShine\Pages\Crud\IndexPage;
use MoonShine\Fields\Relationships\HasMany;
use App\MoonShine\Resources\Dir\DirPetrolStationResource;

class DirPetrolStationBrandIndexPage extends IndexPage
{
    /**
     * getAlias
     * Устанавливает алиас для ресурса.
     * @return string
     */
    public function getAlias(): ?string
    {
        return __('moonshine::directory.resource_list');
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
            Text::make('name')->translatable('moonshine::directory'),
            HasMany::make('count_refillings', 'petrolStations', resource: new DirPetrolStationResource())
                ->onlyLink(
                    'petrolStationBrand',
                    condition: function (int $count, Field $field): bool {
                        return $count > 0;
                    }
                )
                ->translatable('moonshine::directory'),
        ];
    }
}

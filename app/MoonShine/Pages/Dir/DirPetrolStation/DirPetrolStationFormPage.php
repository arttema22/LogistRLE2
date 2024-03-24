<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Dir\DirPetrolStation;

use MoonShine\Fields\Text;
use MoonShine\Decorations\Block;
use App\MoonShine\Pages\Crud\FormPageCustom;
use MoonShine\Fields\Relationships\BelongsTo;
use App\MoonShine\Resources\Dir\DirPetrolStationBrandResource;

class DirPetrolStationFormPage extends FormPageCustom
{
    /**
     * getAlias
     * Устанавливает алиас для ресурса.
     * @return string
     */
    public function getAlias(): ?string
    {
        return __('moonshine::directory.resource_form');
    }

    /**
     * fields
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Block::make([
                BelongsTo::make('brand_id', 'petrolStationBrand', resource: new DirPetrolStationBrandResource())
                    ->required()
                    ->searchable()
                    ->nullable()
                    ->translatable('moonshine::directory'),
                Text::make('address')->required()->translatable('moonshine::directory'),
            ]),
        ];
    }
}

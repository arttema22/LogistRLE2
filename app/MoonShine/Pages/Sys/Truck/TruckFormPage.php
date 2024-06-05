<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Sys\Truck;

use MoonShine\Fields\Text;
use MoonShine\Fields\Field;
use MoonShine\Decorations\Grid;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use Illuminate\Database\Eloquent\Builder;
use App\MoonShine\Pages\Crud\FormPageCustom;
use MoonShine\Fields\Relationships\BelongsTo;
use App\MoonShine\Resources\Dir\DirTruckTypeResource;
use MoonShine\Fields\Relationships\BelongsToMany;
use App\MoonShine\Resources\Dir\DirTruckBrandResource;
use App\MoonShine\Resources\Sys\MoonShineUserResource;

class TruckFormPage extends FormPageCustom
{
    /**
     * getAlias
     * Устанавливает алиас для ресурса.
     * @return string
     */
    public function getAlias(): ?string
    {
        return __('moonshine::system.resource_form');
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
                Grid::make([
                    Column::make([
                        Text::make('name')
                            ->required()
                            ->translatable('moonshine::system.truck'),
                    ])->columnSpan(3, 6),
                    Column::make([
                        Text::make('reg_num_ru')
                            ->required()
                            //->mask('a 999 aa 999')
                            ->translatable('moonshine::system.truck'),
                        Text::make('reg_num_en')
                            ->required()
                            ->mask('a999aa999')
                            ->translatable('moonshine::system.truck'),
                    ])->columnSpan(3, 6),
                    Column::make([
                        BelongsTo::make('brand', 'brand', resource: new DirTruckBrandResource())
                            ->translatable('moonshine::system.truck'),
                    ])->columnSpan(3, 6),
                    Column::make([
                        BelongsTo::make('type', 'type', resource: new DirTruckTypeResource())
                            ->translatable('moonshine::system.truck'),
                    ])->columnSpan(3, 6),
                    Column::make([
                        BelongsTo::make('driver', 'driver', resource: new MoonShineUserResource())
                            ->valuesQuery(fn (Builder $query, Field $field) => $query->where('moonshine_user_role_id', 3))
                            ->translatable('moonshine::system.truck'),
                    ])->columnSpan(3),
                ]),
            ]),
        ];
    }
}

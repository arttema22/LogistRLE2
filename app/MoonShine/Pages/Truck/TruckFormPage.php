<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Truck;

use MoonShine\Fields\Text;
use MoonShine\Fields\Field;
use MoonShine\Decorations\Grid;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use Illuminate\Database\Eloquent\Builder;
use App\MoonShine\Pages\Crud\FormPageCustom;
use MoonShine\Fields\Relationships\BelongsTo;
use App\MoonShine\Resources\DirTruckTypeResource;
use MoonShine\Fields\Relationships\BelongsToMany;
use App\MoonShine\Resources\DirTruckBrandResource;
use App\MoonShine\Resources\MoonShineUserResource;

class TruckFormPage extends FormPageCustom
{
    public function fields(): array
    {
        return [
            Block::make([
                Grid::make([
                    Column::make([
                        Text::make('name')
                            ->required()
                            ->translatable('moonshine::truck'),
                    ])->columnSpan(3, 6),
                    Column::make([
                        Text::make('reg_num_ru')
                            ->required()
                            //->mask('a 999 aa 999')
                            ->translatable('moonshine::truck'),
                        Text::make('reg_num_en')
                            ->required()
                            ->mask('a999aa999')
                            ->translatable('moonshine::truck'),
                    ])->columnSpan(3, 6),
                    Column::make([
                        BelongsTo::make('brand', 'brand', resource: new DirTruckBrandResource())
                            ->translatable('moonshine::directory'),
                    ])->columnSpan(3, 6),
                    Column::make([
                        BelongsTo::make('type', 'type', resource: new DirTruckTypeResource())
                            ->translatable('moonshine::directory'),
                    ])->columnSpan(3, 6),
                    Column::make([
                        BelongsToMany::make('driver', 'users', resource: new MoonShineUserResource())
                            ->valuesQuery(fn (Builder $query, Field $field) => $query->where('moonshine_user_role_id', 3))
                            ->selectMode()
                            ->translatable('moonshine::truck'),
                    ])->columnSpan(3),
                ]),
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

<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use MoonShine\Fields\ID;
use MoonShine\Fields\Text;

use App\Models\DirPetrolStation;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends ModelResource<DirPetrolStation>
 */
class DirPetrolStationResource extends ModelResource
{
    protected string $model = DirPetrolStation::class;

    protected string $title = 'DirPetrolStations';

    public function indexFields(): array
    {
        return [
            ID::make()->sortable(),
            Text::make('name'),
            Text::make('address'),
        ];
    }

    public function formFields(): array
    {
        return [
            ID::make()->sortable(),
        ];
    }

    public function detailFields(): array
    {
        return [
            ID::make()->sortable(),
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }
}

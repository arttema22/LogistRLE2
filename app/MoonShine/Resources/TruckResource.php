<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Truck;
use MoonShine\Fields\ID;

use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Fields\Relationships\BelongsTo;

/**
 * @extends ModelResource<Truck>
 */
class TruckResource extends ModelResource
{
    protected string $model = Truck::class;

    public function title(): string
    {
        return __('moonshine::truck.trucks');
    }

    public function indexFields(): array
    {
        return [
            Text::make('reg_num')->translatable('moonshine::truck'),
            BelongsTo::make('brand', 'brand', resource: new DirTruckBrandResource())
                ->translatable('moonshine::directory'),
        ];
    }

    public function formFields(): array
    {
        return [
            Text::make('reg_num')->translatable('moonshine::truck'),
            BelongsTo::make('brand', 'brand', resource: new DirTruckBrandResource())
                ->translatable('moonshine::directory'),
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

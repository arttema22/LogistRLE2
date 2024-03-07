<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Truck;
use MoonShine\Fields\ID;

use MoonShine\Fields\Text;
use MoonShine\Fields\Field;
use MoonShine\Models\MoonshineUser;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Relationships\BelongsToMany;
use Illuminate\Contracts\Database\Eloquent\Builder;
use MoonShine\Decorations\Block;
use MoonShine\Fields\StackFields;

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
            StackFields::make('truck')->fields([
                Text::make('name')->translatable('moonshine::truck'),
                BelongsTo::make('brand', 'brand', resource: new DirTruckBrandResource())
                    ->translatable('moonshine::directory'),
            ])->translatable('moonshine::truck'),
            BelongsTo::make('type', 'type', resource: new DirTruckTypeResource())
                ->translatable('moonshine::directory'),
            BelongsToMany::make('driver', 'users', resource: new MoonShineUserResource())
                ->inLine(separator: ', ')
                ->translatable('moonshine::truck'),
        ];
    }

    public function formFields(): array
    {
        return [
            Text::make('name')->translatable('moonshine::truck'),
            Text::make('reg_num')->translatable('moonshine::truck'),
            BelongsTo::make('brand', 'brand', resource: new DirTruckBrandResource())
                ->translatable('moonshine::directory'),
            BelongsTo::make('type', 'type', resource: new DirTruckTypeResource())
                ->translatable('moonshine::directory'),
            BelongsToMany::make('driver', 'users', resource: new MoonShineUserResource())
                ->valuesQuery(fn (Builder $query, Field $field) => $query->where('moonshine_user_role_id', 3))
                ->selectMode()
                ->translatable('moonshine::truck'),
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

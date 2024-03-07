<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use MoonShine\Fields\ID;
use MoonShine\Fields\Text;

use App\Models\DirTruckBrand;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Fields\Relationships\BelongsTo;

/**
 * @extends ModelResource<DirTruckBrand>
 */
class DirTruckBrandResource extends ModelResource
{
    protected string $model = DirTruckBrand::class;

    public function title(): string
    {
        return __('moonshine::directory.brand');
    }

    public string $column = 'name';

    public function indexFields(): array
    {
        return [
            Text::make('name')->sortable()->translatable('moonshine::directory'),
        ];
    }

    public function formFields(): array
    {
        return [
            Text::make('name')->translatable('moonshine::directory'),
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }
}

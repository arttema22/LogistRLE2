<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use MoonShine\Fields\Text;

use App\Models\DirTruckType;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends ModelResource<DirTruckType>
 */
class DirTruckTypeResource extends ModelResource
{
    protected string $model = DirTruckType::class;

    public function title(): string
    {
        return __('moonshine::directory.types');
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

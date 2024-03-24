<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Sys\Role;

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

class RoleFormPage extends FormPageCustom
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
                Text::make('name', 'name')
                    ->required()
                    ->translatable('moonshine::system.role'),
            ]),
        ];
    }
}

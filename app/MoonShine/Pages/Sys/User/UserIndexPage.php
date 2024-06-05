<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Sys\User;

use MoonShine\Fields\Text;
use MoonShine\Fields\Position;
use MoonShine\Fields\StackFields;
use MoonShine\Pages\Crud\IndexPage;
use App\Models\Sys\MoonshineUserRole;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Relationships\BelongsToMany;
use App\MoonShine\Resources\Dir\DirTruckTypeResource;
use App\MoonShine\Resources\Dir\DirTruckBrandResource;
use App\MoonShine\Resources\Sys\MoonShineUserResource;
use App\MoonShine\Resources\Sys\MoonShineUserRoleResource;

class UserIndexPage extends IndexPage
{
    /**
     * getAlias
     * Устанавливает алиас для ресурса.
     * @return string
     */
    public function getAlias(): ?string
    {
        return __('moonshine::system.resource_list');
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
            Text::make('name', 'name')
                ->translatable('moonshine::system.user'),
            Text::make('role', 'moonshineUserRole.name')->badge('purple')->translatable('moonshine::system.user'),
        ];
    }
}

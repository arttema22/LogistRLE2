<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Sys;

use MoonShine\Attributes\Icon;
use App\Models\Sys\MoonshineUserRole;
use App\MoonShine\Resources\MainResource;
use App\MoonShine\Pages\Sys\Role\RoleFormPage;
use App\MoonShine\Pages\Sys\Role\RoleIndexPage;

/**
 * MoonShineUserRoleResource
 */
#[Icon('heroicons.outline.bookmark')]
class MoonShineUserRoleResource extends MainResource
{
    // Модель данных
    public string $model = MoonshineUserRole::class;

    // Поле сортировки по умолчанию
    protected string $sortColumn = 'name';

    // Тип сортировки по умолчанию
    protected string $sortDirection = 'ASC';

    // Поле для отображения значений в связях и хлебных крошках
    public string $column = 'name';

    protected bool $isAsync = true;

    /**
     * getAlias
     * Устанавливает алиас для ресурса.
     * @return string
     */
    public function getAlias(): ?string
    {
        return __('moonshine::system.role.resource_role');
    }

    /**
     * title
     * Устанавливает заголовок для ресурса.
     * @return string
     */
    public function title(): string
    {
        return __('moonshine::system.role.roles');
    }

    /**
     * pages
     *
     * @return array
     */
    public function pages(): array
    {
        return [
            RoleIndexPage::make($this->title()),
            RoleFormPage::make(
                $this->getItemID()
                    ? __('moonshine::ui.edit')
                    : __('moonshine::ui.add')
            ),
        ];
    }

    /**
     * rules
     * Правила проверки вводимых данных
     * @param  mixed $item
     * @return array
     */
    public function rules($item): array
    {
        return [
            'name' => 'required|min:5',
        ];
    }

    /**
     * search
     * Поля для поиска
     * @return array
     */
    public function search(): array
    {
        return [
            'name',
        ];
    }
}

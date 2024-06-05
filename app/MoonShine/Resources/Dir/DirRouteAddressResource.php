<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Dir;

use MoonShine\Attributes\Icon;
use App\Models\Dir\DirRouteAddress;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use App\MoonShine\Resources\MainResource;
use App\MoonShine\Pages\Dir\DirRouteAddress\DirRouteAddressFormPage;
use App\MoonShine\Pages\Dir\DirRouteAddress\DirRouteAddressIndexPage;

/**
 * @extends ModelResource<DirRouteAddress>
 */
#[Icon('heroicons.outline.map-pin')]
class DirRouteAddressResource extends MainResource
{
    // Модель данных
    protected string $model = DirRouteAddress::class;

    // Поле сортировки по умолчанию
    protected string $sortColumn = 'name';

    // Тип сортировки по умолчанию
    protected string $sortDirection = 'ASC';

    // Количество элементов на странице
    protected int $itemsPerPage = 15;

    // Поле для отображения значений в связях и хлебных крошках
    public string $column = 'name';

    /**
     * getAlias
     * Устанавливает алиас для ресурса.
     * @return string
     */
    public function getAlias(): ?string
    {
        return __('moonshine::directory.resource_address');
    }

    /**
     * title
     * Устанавливает заголовок для ресурса.
     * @return string
     */
    public function title(): string
    {
        return __('moonshine::directory.addresses');
    }

    /**
     * pages
     *
     * @return array
     */
    public function pages(): array
    {
        return [
            DirRouteAddressIndexPage::make($this->title()),
            DirRouteAddressFormPage::make(
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
    public function rules(Model $item): array
    {
        return [
            'name' => ['required', 'string', 'min:3'],
        ];
    }
}

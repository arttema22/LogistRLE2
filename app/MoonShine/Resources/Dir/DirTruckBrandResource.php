<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Dir;

use MoonShine\Attributes\Icon;
use App\Models\Dir\DirTruckBrand;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use App\MoonShine\Resources\MainResource;
use App\MoonShine\Pages\Dir\DirTruckBrand\DirTruckBrandFormPage;
use App\MoonShine\Pages\Dir\DirTruckBrand\DirTruckBrandIndexPage;

/**
 * @extends ModelResource<DirTruckBrand>
 */
#[Icon('heroicons.outline.truck')]
class DirTruckBrandResource extends MainResource
{
    // Модель данных
    protected string $model = DirTruckBrand::class;

    // Поле сортировки по умолчанию
    protected string $sortColumn = 'name';

    // Тип сортировки по умолчанию
    protected string $sortDirection = 'ASC';

    // Поле для отображения значений в связях и хлебных крошках
    public string $column = 'name';

    /**
     * getAlias
     * Устанавливает алиас для ресурса.
     * @return string
     */
    public function getAlias(): ?string
    {
        return __('moonshine::directory.resource_truck_brand');
    }

    /**
     * title
     * Устанавливает заголовок для ресурса.
     * @return string
     */
    public function title(): string
    {
        return __('moonshine::directory.brands');
    }

    /**
     * pages
     *
     * @return array
     */
    public function pages(): array
    {
        return [
            DirTruckBrandIndexPage::make($this->title()),
            DirTruckBrandFormPage::make(
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

    /**
     * search
     * Поля для поиска
     * @return array
     */
    public function search(): array
    {
        return ['name'];
    }
}

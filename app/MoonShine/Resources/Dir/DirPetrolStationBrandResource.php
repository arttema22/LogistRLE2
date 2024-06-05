<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Dir;

use MoonShine\Attributes\Icon;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use App\Models\Dir\DirPetrolStationBrand;
use App\MoonShine\Resources\MainResource;
use App\MoonShine\Pages\Dir\DirPetrolStationBrand\DirPetrolStationBrandFormPage;
use App\MoonShine\Pages\Dir\DirPetrolStationBrand\DirPetrolStationBrandIndexPage;

/**
 * @extends ModelResource<DirPetrolStationBrand>
 */
#[Icon('heroicons.outline.bookmark')]
class DirPetrolStationBrandResource extends MainResource
{
    // Модель данных
    protected string $model = DirPetrolStationBrand::class;

    // Поле сортировки по умолчанию
    protected string $sortColumn = 'name';

    // Тип сортировки по умолчанию
    protected string $sortDirection = 'DESC';

    // Поле для отображения значений в связях и хлебных крошках
    public string $column = 'name';

    /**
     * getAlias
     * Устанавливает алиас для ресурса.
     * @return string
     */
    public function getAlias(): ?string
    {
        return __('moonshine::directory.resource_brand');
    }

    /**
     * title
     * Устанавливает заголовок для ресурса.
     * @return string
     */
    public function title(): string
    {
        return __('moonshine::directory.petrol_station_brands');
    }

    /**
     * pages
     *
     * @return array
     */
    public function pages(): array
    {
        return [
            DirPetrolStationBrandIndexPage::make($this->title()),
            DirPetrolStationBrandFormPage::make(
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

<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Dir;

use MoonShine\Attributes\Icon;
use App\Models\Dir\DirTruckType;
use App\Models\Tariff\TariffDistance;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use App\MoonShine\Resources\MainResource;
use App\MoonShine\Pages\Dir\DirTruckType\DirTruckTypeFormPage;
use App\MoonShine\Pages\Dir\DirTruckType\DirTruckTypeIndexPage;

/**
 * @extends ModelResource<DirTruckType>
 */
#[Icon('heroicons.outline.truck')]
class DirTruckTypeResource extends MainResource
{
    // Модель данных
    protected string $model = DirTruckType::class;

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
        return __('moonshine::directory.resource_truck_type');
    }

    /**
     * title
     * Устанавливает заголовок для ресурса.
     * @return string
     */
    public function title(): string
    {
        return __('moonshine::directory.types');
    }

    /**
     * pages
     *
     * @return array
     */
    public function pages(): array
    {
        return [
            DirTruckTypeIndexPage::make($this->title()),
            DirTruckTypeFormPage::make(
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

    /**
     * afterCreated
     *
     * @param  mixed $item
     * @return Model
     */
    protected function afterCreated(Model $item): Model
    {
        $tariff = new TariffDistance();
        $item->tariff()->save($tariff);
        return $item;
    }
}

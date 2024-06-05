<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Tariff;

use MoonShine\Attributes\Icon;
use App\Models\Tariff\TariffDistance;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use App\MoonShine\Resources\MainResource;
use Illuminate\Database\Eloquent\Builder;
use App\MoonShine\Pages\Tariff\TariffDistance\TariffDistanceFormPage;
use App\MoonShine\Pages\Tariff\TariffDistance\TariffDistanceIndexPage;

/**
 * @extends ModelResource<TariffDistance>
 */
#[Icon('heroicons.outline.arrows-right-left')]
class TariffDistanceResource extends MainResource
{
    // Модель данных
    protected string $model = TariffDistance::class;

    // Поле сортировки по умолчанию
    protected string $sortColumn = 'truck_type_id';

    // Тип сортировки по умолчанию
    protected string $sortDirection = 'ASC';

    // Поле для отображения значений в связях и хлебных крошках
    public string $column = 'truckType.name';

    /**
     * getActiveActions
     * Разрешенные действия
     * @return array
     */
    public function getActiveActions(): array
    {
        return [
            'update'
        ];
    }

    /**
     * getAlias
     * Устанавливает алиас для ресурса.
     * @return string
     */
    public function getAlias(): ?string
    {
        return __('moonshine::tariff.resource_distance');
    }

    /**
     * title
     * Устанавливает заголовок для ресурса.
     * @return string
     */
    public function title(): string
    {
        return __('moonshine::tariff.tariff_distance');
    }

    /**
     * query
     *
     * @return Builder
     */
    public function query(): Builder
    {
        return parent::query()->with('truckType');
    }

    /**
     * pages
     *
     * @return array
     */
    public function pages(): array
    {
        return [
            TariffDistanceIndexPage::make($this->title()),
            TariffDistanceFormPage::make(
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
        return [];
    }
}

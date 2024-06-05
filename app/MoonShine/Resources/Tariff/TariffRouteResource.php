<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Tariff;

use MoonShine\Attributes\Icon;
use App\Models\Tariff\TariffRoute;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use App\MoonShine\Resources\MainResource;
use App\MoonShine\Pages\Tariff\TariffRoute\TariffRouteFormPage;
use App\MoonShine\Pages\Tariff\TariffRoute\TariffRouteIndexPage;

/**
 * @extends ModelResource<TariffRoute>
 */
#[Icon('heroicons.outline.arrows-right-left')]
class TariffRouteResource extends MainResource
{
    // Модель данных
    protected string $model = TariffRoute::class;

    // Поле сортировки по умолчанию
    protected string $sortColumn = 'id';

    // Тип сортировки по умолчанию
    protected string $sortDirection = 'ASC';

    // Поле для отображения значений в связях и хлебных крошках
    public string $column = 'id';

    /**
     * getAlias
     * Устанавливает алиас для ресурса.
     * @return string
     */
    public function getAlias(): ?string
    {
        return __('moonshine::tariff.resource_route_tariff');
    }

    /**
     * title
     * Устанавливает заголовок для ресурса.
     * @return string
     */
    public function title(): string
    {
        return __('moonshine::tariff.routes');
    }

    /**
     * pages
     *
     * @return array
     */
    public function pages(): array
    {
        return [
            TariffRouteIndexPage::make($this->title()),
            TariffRouteFormPage::make(
                $this->getItemID()
                    ? __('moonshine::ui.edit')
                    : __('moonshine::ui.add')
            ),
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }
}

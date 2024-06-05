<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Service;
use MoonShine\Attributes\Icon;
use Illuminate\Support\Facades\Auth;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\MoonShine\Pages\Service\ServiceFormPage;
use App\MoonShine\Pages\Service\ServiceIndexPage;
use App\MoonShine\Pages\Service\ServiceDetailPage;

/**
 * @extends ModelResource<Service>
 */
#[Icon('heroicons.outline.banknotes')]
class ServiceResource extends MainResource
{
    // Модель данных
    protected string $model = Service::class;

    // Поле сортировки по умолчанию
    protected string $sortColumn = 'date';

    // Тип сортировки по умолчанию
    protected string $sortDirection = 'DESC';

    // Поле для отображения значений в связях и хлебных крошках
    public string $column = 'service.name';

    /**
     * getAlias
     * Устанавливает алиас для ресурса.
     * @return string
     */
    public function getAlias(): ?string
    {
        return __('moonshine::service.resource_page');
    }

    /**
     * title
     * Устанавливает заголовок для ресурса.
     * @return string
     */
    public function title(): string
    {
        return __('moonshine::service.services');
    }

    /**
     * query
     *
     * @return Builder
     */
    public function query(): Builder
    {
        if (Auth::user()->moonshine_user_role_id == 3)
            return parent::query()
                ->where('driver_id', Auth::user()->id)
                ->with('driver')
                ->with('service.tariff');

        return parent::query()->with('driver')->with('service.tariff');
    }

    /**
     * pages
     *
     * @return array
     */
    public function pages(): array
    {
        return [
            ServiceIndexPage::make($this->title()),
            ServiceFormPage::make(
                $this->getItemID()
                    ? __('moonshine::ui.edit')
                    : __('moonshine::ui.add')
            ),
            ServiceDetailPage::make(__('moonshine::ui.show')),
        ];
    }

    /**
     * rules
     *
     * @param  mixed $item
     * @return array
     */
    public function rules(Model $item): array
    {
        return [];
    }

    /**
     * beforeCreating
     *
     * @param  mixed $item
     * @return Model
     */
    protected function beforeCreating(Model $item): Model
    {
        $item->owner_id = Auth::user()->id; // Запоминаем владельца
        // Если владелец водитель, то запоминаем водителя
        if (Auth::user()->moonshine_user_role_id == 3) {
            $item->driver_id = Auth::user()->id;
        }
        return $item;
    }

    protected function afterCreated(Model $item): Model
    {
        // Если услуга привязана к маршруту, то дата услуги устанавливается как дата маршрута
        if ($item->is_route) {
            $item->date = $item->route->date;
            $item->save();
        }
        return $item;
    }
}

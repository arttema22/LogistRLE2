<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Tariff;

use Closure;
use App\Models\Dir\DirService;
use MoonShine\Attributes\Icon;
use App\Models\Tariff\TariffService;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use App\MoonShine\Resources\MainResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\ComponentAttributeBag;
use App\MoonShine\Pages\Tariff\TariffService\TariffServiceFormPage;
use App\MoonShine\Pages\Tariff\TariffService\TariffServiceIndexPage;

/**
 * @extends ModelResource<DirService>
 */
#[Icon('heroicons.outline.wrench')]
class TariffServiceResource extends MainResource
{
    // Модель данных
    protected string $model = TariffService::class;

    // Поле сортировки по умолчанию
    protected string $sortColumn = 'service_id';

    // Тип сортировки по умолчанию
    protected string $sortDirection = 'ASC';

    // Поле для отображения значений в связях и хлебных крошках
    public string $column = 'service.name';

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
        return __('moonshine::tariff.resource_service');
    }

    /**
     * title
     * Устанавливает заголовок для ресурса.
     * @return string
     */
    public function title(): string
    {
        return __('moonshine::tariff.services');
    }

    /**
     * query
     *
     * @return Builder
     */
    public function query(): Builder
    {
        return parent::query()->with('service');
    }

    /**
     * pages
     *
     * @return array
     */
    public function pages(): array
    {
        return [
            TariffServiceIndexPage::make($this->title()),
            TariffServiceFormPage::make(
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
            'price' => ['required', 'decimal:0,2', 'min:9', 'max:999999.99'],
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
            'service.name', 'price',
        ];
    }

    /**
     * trAttributes
     * Если цена в записи равна 0, то она красная.
     * @return Closure
     */
    public function trAttributes(): Closure
    {
        return function (
            Model $item,
            int $row,
            ComponentAttributeBag $attr
        ): ComponentAttributeBag {
            if ($item->price == 0) {
                $attr->setAttributes([
                    'class' => 'bgc-red'
                ]);
            }
            return $attr;
        };
    }
}

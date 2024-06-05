<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Dir;

use MoonShine\Attributes\Icon;
use App\Models\Dir\DirFuelType;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use App\MoonShine\Resources\MainResource;
use Illuminate\Database\Eloquent\Builder;
use App\MoonShine\Pages\Dir\DirFuelType\DirFuelTypeFormPage;
use App\MoonShine\Pages\Dir\DirFuelType\DirFuelTypeIndexPage;

/**
 * @extends ModelResource<DirFuelType>
 */
#[Icon('heroicons.outline.circle-stack')]
class DirFuelTypeResource extends MainResource
{
    // Модель данных
    protected string $model = DirFuelType::class;

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
        return __('moonshine::directory.resource_fuel');
    }

    /**
     * title
     * Устанавливает заголовок для ресурса.
     * @return string
     */
    public function title(): string
    {
        return __('moonshine::directory.fuels');
    }

    /**
     * query
     *
     * @return Builder
     */
    public function query(): Builder
    {
        return parent::query()
            ->with('fuelCategory');
    }

    /**
     * pages
     *
     * @return array
     */
    public function pages(): array
    {
        return [
            DirFuelTypeIndexPage::make($this->title()),
            DirFuelTypeFormPage::make(
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
            'name' => ['required', 'string', 'min:2'],
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

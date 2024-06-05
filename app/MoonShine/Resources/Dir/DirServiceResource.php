<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Dir;

use App\Models\Dir\DirService;
use App\Models\Tariff\TariffService;
use MoonShine\Attributes\Icon;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use App\MoonShine\Resources\MainResource;
use Illuminate\Database\Eloquent\Builder;
use App\MoonShine\Pages\Dir\DirService\DirServiceFormPage;
use App\MoonShine\Pages\Dir\DirService\DirServiceIndexPage;

/**
 * @extends ModelResource<DirService>
 */
#[Icon('heroicons.outline.truck')]
class DirServiceResource extends MainResource
{
    // Модель данных
    protected string $model = DirService::class;

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
        return __('moonshine::directory.resource_dir_service');
    }

    /**
     * title
     * Устанавливает заголовок для ресурса.
     * @return string
     */
    public function title(): string
    {
        return __('moonshine::directory.services');
    }

    /**
     * query
     *
     * @return Builder
     */
    public function query(): Builder
    {
        return parent::query()->with('tariff');
    }

    /**
     * pages
     *
     * @return array
     */
    public function pages(): array
    {
        return [
            DirServiceIndexPage::make($this->title()),
            DirServiceFormPage::make(
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
     * afterCreated
     *
     * @param  mixed $item
     * @return Model
     */
    protected function afterCreated(Model $item): Model
    {
        $tariff = new TariffService();
        $tariff->price = 0;
        $item->tariff()->save($tariff);
        return $item;
    }
}

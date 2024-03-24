<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Dir;

use App\Models\Dir\DirService;
use MoonShine\Attributes\Icon;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use App\MoonShine\Pages\Dir\DirService\DirServiceFormPage;
use App\MoonShine\Pages\Dir\DirService\DirServiceIndexPage;

/**
 * @extends ModelResource<DirService>
 */
#[Icon('heroicons.outline.circle-stack')]
class DirServiceResource extends DirResource
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
        return __('moonshine::directory.resource_service');
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
            'name', 'price',
        ];
    }
}

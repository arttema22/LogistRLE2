<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Dir;

use App\Models\Dir\DirCargo;
use MoonShine\Attributes\Icon;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use App\MoonShine\Resources\MainResource;
use App\MoonShine\Pages\Dir\DirCargo\DirCargoFormPage;
use App\MoonShine\Pages\Dir\DirCargo\DirCargoIndexPage;

/**
 * @extends ModelResource<DirCargo>
 */
#[Icon('heroicons.outline.circle-stack')]
class DirCargoResource extends MainResource
{
    // Модель данных
    protected string $model = DirCargo::class;

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
        return __('moonshine::directory.resource_cargo');
    }

    /**
     * title
     * Устанавливает заголовок для ресурса.
     * @return string
     */
    public function title(): string
    {
        return __('moonshine::directory.cargos');
    }

    /**
     * pages
     *
     * @return array
     */
    public function pages(): array
    {
        return [
            DirCargoIndexPage::make($this->title()),
            DirCargoFormPage::make(
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
        return [
            'name',
        ];
    }
}

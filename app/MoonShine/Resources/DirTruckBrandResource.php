<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use MoonShine\Fields\Text;

use App\Models\DirTruckBrand;
use MoonShine\Enums\PageType;
use MoonShine\Attributes\Icon;
use MoonShine\Decorations\Block;
use MoonShine\Handlers\ExportHandler;
use MoonShine\Handlers\ImportHandler;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends ModelResource<DirTruckBrand>
 */
#[Icon('heroicons.outline.truck')]
class DirTruckBrandResource extends ModelResource
{
    // Модель данных
    protected string $model = DirTruckBrand::class;

    // Редирект после сохранения
    protected ?PageType $redirectAfterSave = PageType::INDEX;

    // Редирект после удаления
    protected ?PageType $redirectAfterDelete = PageType::INDEX;

    // Поле сортировки по умолчанию
    protected string $sortColumn = 'name';

    // Тип сортировки по умолчанию
    protected string $sortDirection = 'ASC';

    // Количество элементов на странице
    protected int $itemsPerPage = 15;

    // Поле для отображения значений в связях и хлебных крошках
    public string $column = 'name';

    public function title(): string
    {
        return __('moonshine::directory.brands');
    }

    // Разрешенные действия
    public function getActiveActions(): array
    {
        return [
            'create', 'update', 'delete'
        ];
    }

    public function indexFields(): array
    {
        return [
            Text::make('name')->sortable()->translatable('moonshine::directory'),
        ];
    }

    public function formFields(): array
    {
        return [
            Block::make([
                Text::make('name')
                    ->required()
                    ->translatable('moonshine::directory'),
            ]),
        ];
    }

    public function rules(Model $item): array
    {
        return [
            'name' => ['required', 'string', 'min:3'],
        ];
    }

    // Поля для поиска
    public function search(): array
    {
        return ['name'];
    }

    public function import(): ?ImportHandler
    {
        return null;
    }

    public function export(): ?ExportHandler
    {
        return null;
    }
}

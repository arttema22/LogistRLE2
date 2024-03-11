<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use MoonShine\Enums\Layer;
use MoonShine\Fields\Text;
use MoonShine\Fields\Field;
use MoonShine\Enums\PageType;
use MoonShine\Attributes\Icon;
use MoonShine\Fields\Position;
use App\Models\DirPetrolStation;
use MoonShine\Decorations\Block;
use MoonShine\Handlers\ExportHandler;
use MoonShine\Handlers\ImportHandler;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Fields\Relationships\HasMany;
use MoonShine\ChangeLog\Components\ChangeLog;

/**
 * @extends ModelResource<DirPetrolStation>
 */
#[Icon('heroicons.outline.battery-50')]
class DirPetrolStationResource extends ModelResource
{
    // Модель данных
    protected string $model = DirPetrolStation::class;

    // Проверка прав доступа
    protected bool $withPolicy = false;

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
        return __('moonshine::directory.petrol_station');
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
            Position::make(),
            Text::make('name')->translatable('moonshine::directory'),
            Text::make('address')->translatable('moonshine::directory'),
            HasMany::make('count_refillings', 'refillings', resource: new RefillingResource())
                ->onlyLink('petrolStation', condition: function (int $count, Field $field): bool {
                    return $count > 0;
                })->translatable('moonshine::directory'),
        ];
    }

    public function formFields(): array
    {
        return [
            Block::make([
                Text::make('name')->required()->translatable('moonshine::directory'),
                Text::make('address')->required()->translatable('moonshine::directory'),
            ]),
        ];
    }

    public function rules(Model $item): array
    {
        return [
            'name' => ['required', 'string', 'min:3'],
            'address' => ['required', 'string', 'min:3'],
        ];
    }

    // Поля для поиска
    public function search(): array
    {
        return [
            'name', 'address',
        ];
    }

    public function import(): ?ImportHandler
    {
        return null;
    }

    public function export(): ?ExportHandler
    {
        return null;
    }

    // Логирование изменений
    protected function onBoot(): void
    {
        $this->getPages()
            ->formPage()
            ->pushToLayer(
                Layer::BOTTOM,
                ChangeLog::make('Changelog', $this)
            );
    }
}

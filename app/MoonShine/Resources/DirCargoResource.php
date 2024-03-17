<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\DirCargo;
use MoonShine\Fields\ID;
use MoonShine\Enums\Layer;
use MoonShine\Fields\Text;
use MoonShine\Enums\PageType;
use MoonShine\Attributes\Icon;
use MoonShine\Fields\Position;
use MoonShine\Decorations\Block;
use MoonShine\Handlers\ExportHandler;
use MoonShine\Handlers\ImportHandler;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use MoonShine\ChangeLog\Components\ChangeLog;

/**
 * @extends ModelResource<DirCargo>
 */
#[Icon('heroicons.outline.circle-stack')]
class DirCargoResource extends ModelResource
{
    // Модель данных
    protected string $model = DirCargo::class;

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
     * getActiveActions
     * Разрешенные действия
     * @return array
     */
    public function getActiveActions(): array
    {
        return [
            'create', 'update', 'delete'
        ];
    }

    /**
     * indexFields
     *
     * @return array
     */
    public function indexFields(): array
    {
        return [
            Position::make(),
            Text::make('name')->sortable()->translatable('moonshine::directory'),
        ];
    }

    /**
     * formFields
     *
     * @return array
     */
    public function formFields(): array
    {
        return [
            Block::make([
                Text::make('name')->required()->translatable('moonshine::directory'),
            ]),
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

    /**
     * import
     * Импорт данных
     * @return ImportHandler
     */
    public function import(): ?ImportHandler
    {
        return null;
    }

    /**
     * export
     * Экспорт данных
     * @return ExportHandler
     */
    public function export(): ?ExportHandler
    {
        return null;
    }

    /**
     * onBoot
     * Логирование изменений
     * @return void
     */
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

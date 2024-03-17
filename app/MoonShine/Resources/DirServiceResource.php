<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use MoonShine\Fields\ID;
use App\Models\DirService;

use MoonShine\Enums\Layer;
use MoonShine\Fields\Text;
use MoonShine\Fields\Number;
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
 * @extends ModelResource<DirService>
 */
#[Icon('heroicons.outline.circle-stack')]
class DirServiceResource extends ModelResource
{
    // Модель данных
    protected string $model = DirService::class;

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
            Text::make('price')->sortable()->translatable('moonshine::directory'),
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
                Number::make('price')->required()
                    ->min(9)->max(999999.99)->step(0.01)
                    ->translatable('moonshine::directory'),
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

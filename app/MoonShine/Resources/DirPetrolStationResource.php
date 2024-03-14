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
use MoonShine\Fields\Relationships\BelongsTo;

/**
 * @extends ModelResource<DirPetrolStation>
 */
#[Icon('heroicons.outline.battery-50')]
class DirPetrolStationResource extends ModelResource
{
    // Модель данных
    protected string $model = DirPetrolStation::class;

    // Проверка прав доступа
    protected bool $withPolicy = true;

    // Редирект после сохранения
    protected ?PageType $redirectAfterSave = PageType::INDEX;

    // Редирект после удаления
    protected ?PageType $redirectAfterDelete = PageType::INDEX;

    // Поле сортировки по умолчанию
    protected string $sortColumn = 'address';

    // Тип сортировки по умолчанию
    protected string $sortDirection = 'ASC';

    // Количество элементов на странице
    protected int $itemsPerPage = 15;

    // Поле для отображения значений в связях и хлебных крошках
    public string $column = 'address';

    /**
     * getAlias
     * Устанавливает алиас для ресурса.
     * @return string
     */
    public function getAlias(): ?string
    {
        return __('moonshine::directory.resource_station');
    }

    /**
     * title
     * Устанавливает заголовок для ресурса.
     * @return string
     */
    public function title(): string
    {
        return __('moonshine::directory.petrol_station');
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
            Text::make('address')->sortable()->translatable('moonshine::directory'),
            BelongsTo::make('brand_id', 'petrolStationBrand', resource: new DirPetrolStationBrandResource())
                ->translatable('moonshine::directory'),
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
                BelongsTo::make('brand_id', 'petrolStationBrand', resource: new DirPetrolStationBrandResource())
                    ->required()
                    ->searchable()
                    ->nullable()
                    ->translatable('moonshine::directory'),
                Text::make('address')->required()->translatable('moonshine::directory'),
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
            'address' => ['required', 'string', 'min:3'],
            'brand_id' => ['required'],
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
            'name', 'address',
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

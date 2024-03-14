<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use MoonShine\Enums\Layer;
use MoonShine\Fields\Text;
use MoonShine\Fields\Field;
use MoonShine\Enums\PageType;
use MoonShine\Attributes\Icon;
use MoonShine\Fields\Position;
use MoonShine\Decorations\Block;
use App\Models\DirPetrolStationBrand;
use MoonShine\Handlers\ExportHandler;
use MoonShine\Handlers\ImportHandler;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Fields\Relationships\HasMany;
use MoonShine\ChangeLog\Components\ChangeLog;

/**
 * @extends ModelResource<DirPetrolStationBrand>
 */
#[Icon('heroicons.outline.bookmark')]
class DirPetrolStationBrandResource extends ModelResource
{
    // Модель данных
    protected string $model = DirPetrolStationBrand::class;

    // Проверка прав доступа
    protected bool $withPolicy = true;

    // Редирект после сохранения
    protected ?PageType $redirectAfterSave = PageType::INDEX;

    // Редирект после удаления
    protected ?PageType $redirectAfterDelete = PageType::INDEX;

    // Поле сортировки по умолчанию
    protected string $sortColumn = 'name';

    // Тип сортировки по умолчанию
    protected string $sortDirection = 'DESC';

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
        return __('moonshine::directory.resource_brand');
    }

    /**
     * title
     * Устанавливает заголовок для ресурса.
     * @return string
     */
    public function title(): string
    {
        return __('moonshine::directory.petrol_station_brands');
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
            Text::make('name')->translatable('moonshine::directory'),
            HasMany::make('count_refillings', 'petrolStations', resource: new DirPetrolStationResource())
                ->onlyLink(
                    'petrolStationBrand',
                    condition: function (int $count, Field $field): bool {
                        return $count > 0;
                    }
                )
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

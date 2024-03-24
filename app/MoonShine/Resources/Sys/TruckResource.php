<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Sys;

use App\Models\Sys\Truck;
use MoonShine\Enums\Layer;
use MoonShine\Fields\Text;
use MoonShine\Enums\PageType;
use MoonShine\Attributes\Icon;
use MoonShine\QueryTags\QueryTag;
use MoonShine\Handlers\ExportHandler;
use MoonShine\Handlers\ImportHandler;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\MoonShine\Pages\Sys\Truck\TruckFormPage;
use App\MoonShine\Pages\Sys\Truck\TruckIndexPage;
use MoonShine\ChangeLog\Components\ChangeLog;
use MoonShine\Fields\Relationships\BelongsTo;
use App\MoonShine\Pages\Sys\Truck\TruckDetailPage;
use App\MoonShine\Resources\Dir\DirTruckTypeResource;
use App\MoonShine\Resources\Dir\DirTruckBrandResource;


/**
 * @extends ModelResource<Truck>
 */
#[Icon('heroicons.outline.truck')]
class TruckResource extends ModelResource
{
    // Модель данных
    protected string $model = Truck::class;

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
    public string $column = 'reg_num_ru';

    public function title(): string
    {
        return __('moonshine::truck.trucks');
    }

    // Разрешенные действия
    public function getActiveActions(): array
    {
        return [
            'create', 'update', 'delete'
        ];
    }

    public function pages(): array
    {
        return [
            TruckIndexPage::make($this->title()),
            TruckFormPage::make(
                $this->getItemID()
                    ? __('moonshine::ui.edit')
                    : __('moonshine::ui.add')
            ),
            TruckDetailPage::make(__('moonshine::ui.show')),
        ];
    }

    public function rules(Model $item): array
    {
        return [
            'name' => ['required', 'string', 'min:3'],
            'reg_num_ru' => ['required'],
            'reg_num_en' => ['required'],
        ];
    }

    // Фильтры
    public function filters(): array
    {
        return [
            Text::make('name', 'name')->translatable('moonshine::truck'),
            BelongsTo::make('brand', 'brand', resource: new DirTruckBrandResource())
                ->nullable()
                ->translatable('moonshine::directory'),
            BelongsTo::make('type', 'type', resource: new DirTruckTypeResource())
                ->nullable()
                ->translatable('moonshine::directory'),
        ];
    }

    // Поля для поиска
    public function search(): array
    {
        return [
            'name', 'reg_num_ru', 'reg_num_en', 'brand.name',
            'type.name', 'users.name'
        ];
    }

    // Быстрые фильтры
    public function queryTags(): array
    {
        return [
            QueryTag::make(
                __('moonshine::truck.all'),
                fn (Builder $query) => $query
            )->default(),
            QueryTag::make(
                'Щеповозы',
                fn (Builder $query) => $query->where('type_id', 1)
            ),
            QueryTag::make(
                'Тенты',
                fn (Builder $query) => $query->where('type_id', 2)
            ),
            QueryTag::make(
                'Лесовозы',
                fn (Builder $query) => $query->where('type_id', 3)
            ),
            QueryTag::make(
                'Лесовозы-фишки',
                fn (Builder $query) => $query->where('type_id', 4)
            ),
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

<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Truck;
use MoonShine\Fields\Text;
use MoonShine\Fields\Field;
use MoonShine\Enums\PageType;
use MoonShine\Attributes\Icon;
use MoonShine\Decorations\Grid;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Fields\StackFields;
use MoonShine\QueryTags\QueryTag;
use MoonShine\Handlers\ExportHandler;
use MoonShine\Handlers\ImportHandler;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Relationships\BelongsToMany;
use Illuminate\Contracts\Database\Eloquent\Builder;

/**
 * @extends ModelResource<Truck>
 */
#[Icon('heroicons.outline.truck')]
class TruckResource extends ModelResource
{
    // Модель данных
    protected string $model = Truck::class;

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
    public string $column = 'reg_num';

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

    public function indexFields(): array
    {
        return [
            Text::make('reg_num')->sortable()
                ->translatable('moonshine::truck'),
            StackFields::make('truck')->fields([
                Text::make('name')->translatable('moonshine::truck'),
                BelongsTo::make('brand', 'brand', resource: new DirTruckBrandResource())
                    ->translatable('moonshine::directory'),
            ])->translatable('moonshine::truck'),
            BelongsTo::make('type', 'type', resource: new DirTruckTypeResource())
                ->sortable()
                ->translatable('moonshine::directory'),
            BelongsToMany::make('driver', 'users', resource: new MoonShineUserResource())
                ->inLine(separator: ', ')
                ->translatable('moonshine::truck'),
        ];
    }

    public function formFields(): array
    {
        return [
            Block::make([
                Grid::make([
                    Column::make([
                        Text::make('name')
                            ->required()
                            ->translatable('moonshine::truck'),
                    ])->columnSpan(3, 6),
                    Column::make([
                        Text::make('reg_num')
                            ->required()
                            ->mask('a 999 aa 999')
                            ->translatable('moonshine::truck'),
                    ])->columnSpan(3, 6),
                    Column::make([
                        BelongsTo::make('brand', 'brand', resource: new DirTruckBrandResource())
                            ->translatable('moonshine::directory'),
                    ])->columnSpan(3, 6),
                    Column::make([
                        BelongsTo::make('type', 'type', resource: new DirTruckTypeResource())
                            ->translatable('moonshine::directory'),
                    ])->columnSpan(3, 6),
                    Column::make([
                        BelongsToMany::make('driver', 'users', resource: new MoonShineUserResource())
                            ->valuesQuery(fn (Builder $query, Field $field) => $query->where('moonshine_user_role_id', 3))
                            ->selectMode()
                            ->translatable('moonshine::truck'),
                    ])->columnSpan(3),
                ]),
            ]),
        ];
    }

    public function rules(Model $item): array
    {
        return [
            'name' => ['required', 'string', 'min:3'],
            'reg_num' => ['required'],
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
        return ['name', 'reg_num', 'brand.name', 'type.name', 'users.name'];
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
}

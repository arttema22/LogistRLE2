<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Salary;
use MoonShine\Fields\ID;

use MoonShine\Enums\Layer;
use MoonShine\Fields\Date;
use MoonShine\Fields\Text;
use MoonShine\Fields\Field;
use MoonShine\Enums\PageType;
use MoonShine\Attributes\Icon;
use MoonShine\Fields\Position;
use MoonShine\Fields\Textarea;
use MoonShine\Decorations\Block;
use MoonShine\QueryTags\QueryTag;
use MoonShine\Components\Offcanvas;
use Illuminate\Support\Facades\Auth;
use MoonShine\Handlers\ExportHandler;
use MoonShine\Handlers\ImportHandler;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use MoonShine\ActionButtons\ActionButton;
use MoonShine\ChangeLog\Components\ChangeLog;
use MoonShine\Components\When;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Metrics\LineChartMetric;

/**
 * @extends ModelResource<Salary>
 */
#[Icon('heroicons.outline.banknotes')]
class SalaryResource extends ModelResource
{
    // Модель данных
    protected string $model = Salary::class;

    // Проверка прав доступа
    protected bool $withPolicy = false;

    // Редирект после сохранения
    protected ?PageType $redirectAfterSave = PageType::INDEX;

    // Редирект после удаления
    protected ?PageType $redirectAfterDelete = PageType::INDEX;

    // Поле сортировки по умолчанию
    protected string $sortColumn = 'date';

    // Тип сортировки по умолчанию
    protected string $sortDirection = 'DESC';

    // Количество элементов на странице
    protected int $itemsPerPage = 15;

    // Поле для отображения значений в связях и хлебных крошках
    public string $column = 'date';

    public function title(): string
    {
        return __('moonshine::salary.salaries');
    }

    // Разрешенные действия
    public function getActiveActions(): array
    {
        return [
            'create', 'update', 'delete'
        ];
    }

    public function query(): Builder
    {
        if (Auth::user()->moonshine_user_role_id == 3) return parent::query()
            ->where('driver_id', Auth::user()->id);

        return parent::query();
    }

    public function indexFields(): array
    {
        return [
            Position::make(),
            Date::make('date')->format('d.m.Y')->sortable()
                ->translatable('moonshine::salary'),
            BelongsTo::make('driver', 'driver', resource: new MoonShineUserResource())
                ->sortable()
                ->when(
                    Auth::user()->moonshine_user_role_id === 3,
                    fn (Field $field) => $field->hideOnIndex(),
                )
                ->translatable('moonshine::salary'),
            Text::make('salary')
                ->translatable('moonshine::salary'),
            Textarea::make('comment')->translatable('moonshine::salary'),
        ];
    }

    public function formFields(): array
    {
        return [
            Block::make([
                Date::make('date')->required()
                    ->translatable('moonshine::salary'),
                BelongsTo::make('driver', 'driver', resource: new MoonShineUserResource())
                    ->valuesQuery(fn (Builder $query, Field $field) => $query->where('moonshine_user_role_id', 3))
                    ->translatable('moonshine::salary')
                    ->when(
                        Auth::user()->moonshine_user_role_id === 3,
                        fn (Field $field) => $field->hideOnForm(),
                    ),
                Text::make('salary')->required()
                    ->translatable('moonshine::salary'),
                Textarea::make('comment')->translatable('moonshine::salary'),
            ]),
        ];
    }

    public function rules(Model $item): array
    {
        return [
            'date' => ['required', 'date'],
            'salary' => ['required'],
        ];
    }

    // Фильтры
    public function filters(): array
    {
        return [
            Date::make('date', 'date')->translatable('moonshine::refilling'),
            BelongsTo::make('driver', 'driver', resource: new MoonShineUserResource())
                ->valuesQuery(fn (Builder $query, Field $field) => $query->where('moonshine_user_role_id', 3))
                ->nullable()
                ->translatable('moonshine::refilling'),
        ];
    }

    // Поля для поиска
    public function search(): array
    {
        return [
            'date', 'driver.name',
        ];
    }

    // Быстрые фильтры
    public function queryTags(): array
    {
        return [
            QueryTag::make(
                __('moonshine::salary.all'),
                fn (Builder $query) => $query
            )->default(),
            QueryTag::make(
                __('moonshine::salary.archive'),
                fn (Builder $query) => $query->onlyTrashed()
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

    protected function beforeCreating(Model $item): Model
    {
        $item->owner_id = Auth::user()->id;

        if (Auth::user()->moonshine_user_role_id == 3) {
            $item->driver_id = Auth::user()->id;
        }

        return $item;
    }

    public function metrics(): array
    {
        return [
            When::make(
                static fn () => Auth::user()->moonshine_user_role_id === 3,
                static fn () => [
                    LineChartMetric::make('salaries')
                        ->line([
                            __('moonshine::salary.sum') => Salary::query()
                                ->selectRaw('SUM(salary) as sum, DATE_FORMAT(date, "%d.%m.%Y") as date')
                                ->where('driver_id', Auth::user()->id)
                                ->groupBy('date')
                                ->pluck('sum', 'date')
                                ->toArray()
                        ], 'rgb(42, 69, 35)')->translatable('moonshine::salary')
                ]
            ),
            When::make(
                static fn () => Auth::user()->moonshine_user_role_id != 3,
                static fn () => [
                    LineChartMetric::make('salaries')
                        ->line(
                            [
                                __('moonshine::salary.sum') => Salary::query()
                                    ->selectRaw('SUM(salary) as sum, DATE_FORMAT(date, "%d.%m.%Y") as date')
                                    ->groupBy('date')
                                    ->pluck('sum', 'date')
                                    ->toArray(),
                                __('moonshine::salary.avg') => Salary::query()
                                    ->selectRaw('AVG(salary) as avg, DATE_FORMAT(date, "%d.%m.%Y") as date')
                                    ->groupBy('date')
                                    ->pluck('avg', 'date')
                                    ->toArray()
                            ],
                            ['rgb(42, 69, 35)', 'rgb(93, 160, 53)']
                        )->translatable('moonshine::salary')
                ]
            ),
        ];
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

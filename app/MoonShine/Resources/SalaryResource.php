<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Salary;
use MoonShine\Fields\ID;

use MoonShine\Enums\Layer;
use MoonShine\Fields\Date;
use MoonShine\Fields\Text;
use MoonShine\Fields\Field;
use MoonShine\Fields\Number;
use MoonShine\Enums\PageType;
use MoonShine\Fields\Preview;
use MoonShine\Attributes\Icon;
use MoonShine\Components\When;
use MoonShine\Fields\Position;
use MoonShine\Fields\Textarea;
use MoonShine\Decorations\Block;
use MoonShine\QueryTags\QueryTag;
use MoonShine\Decorations\Heading;
use MoonShine\Components\Offcanvas;
use Illuminate\Support\Facades\Auth;
use MoonShine\Handlers\ExportHandler;
use MoonShine\Handlers\ImportHandler;
use MoonShine\Metrics\LineChartMetric;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use MoonShine\ActionButtons\ActionButton;
use MoonShine\ChangeLog\Components\ChangeLog;
use MoonShine\Fields\Relationships\BelongsTo;

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

    // Модальное окно при создании
    protected bool $createInModal = true;

    // Модальное окно при редактировании
    protected bool $editInModal = true;

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
            Preview::make()
                ->link('https://github.com/arttema22/LogistRLE2/wiki/%D0%92%D1%8B%D0%BF%D0%BB%D0%B0%D1%82%D1%8B', __('moonshine::ui.help'), blank: true),
            Block::make([
                Date::make('date')->required()
                    ->translatable('moonshine::salary'),
                BelongsTo::make('driver', 'driver', resource: new MoonShineUserResource())
                    ->valuesQuery(fn (Builder $query, Field $field) => $query->where('moonshine_user_role_id', 3))
                    ->required()
                    ->nullable()
                    ->translatable('moonshine::salary')
                    ->when(
                        Auth::user()->moonshine_user_role_id === 3,
                        fn (Field $field) => $field->hideOnForm(),
                    ),
                Number::make('salary')->required()
                    ->min(10)->max(9999999.99)->step(0.01)
                    ->translatable('moonshine::salary'),
                Textarea::make('comment')->translatable('moonshine::salary'),
            ]),
        ];
    }

    public function rules(Model $item): array
    {
        return [
            'date' => ['required', 'date', 'before_or_equal:today'],
            'driver_id' => ['required'],
            'salary' => ['required', 'decimal:0,2', 'min:10', 'max:9999999.99'],
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

    public function formButtons(): array
    {
        return [
            ActionButton::make('Link', '/endpoint'),
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

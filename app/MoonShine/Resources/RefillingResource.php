<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Closure;
use App\Models\Refilling;
use MoonShine\Enums\Layer;
use MoonShine\Fields\Date;
use MoonShine\Fields\Field;

use MoonShine\Enums\PageType;
use MoonShine\Attributes\Icon;
use MoonShine\QueryTags\QueryTag;
use Spatie\Valuestore\Valuestore;
use Illuminate\Support\Facades\Auth;
use MoonShine\Handlers\ExportHandler;
use MoonShine\Handlers\ImportHandler;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\ComponentAttributeBag;
use MoonShine\ChangeLog\Components\ChangeLog;
use MoonShine\Fields\Relationships\BelongsTo;
use App\MoonShine\Pages\Refilling\RefillingFormPage;
use App\MoonShine\Pages\Refilling\RefillingIndexPage;
use App\MoonShine\Pages\Refilling\RefillingDetailPage;

/**
 * @extends ModelResource<Refilling>
 */
#[Icon('heroicons.outline.battery-50')]
class RefillingResource extends ModelResource
{
    // Модель данных
    protected string $model = Refilling::class;

    // Проверка прав доступа
    protected bool $withPolicy = true;

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

    public function getAlias(): ?string
    {
        return __('moonshine::refilling.resource_page');
    }

    public function title(): string
    {
        return __('moonshine::refilling.refillings');
    }

    public function query(): Builder
    {
        if (Auth::user()->moonshine_user_role_id == 3)
            return parent::query()
                ->where('driver_id', Auth::user()->id);

        return parent::query();
    }

    public function pages(): array
    {
        return [
            RefillingIndexPage::make($this->title()),
            RefillingFormPage::make(
                $this->getItemID()
                    ? __('moonshine::ui.edit')
                    : __('moonshine::ui.add')
            ),
            RefillingDetailPage::make(__('moonshine::ui.show')),
        ];
    }

    public function rules(Model $item): array
    {
        return [
            'date' => ['required', 'date', 'before_or_equal:today'],
            //            'salary' => ['required', 'decimal:0,2', 'min:10', 'max:9999999.99'],];
            'num_liters_car_refueling' => ['required'],
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
                ->translatable('moonshine::refilling')
                ->when(
                    Auth::user()->moonshine_user_role_id == 3,
                    fn (Field $field) => $field->disabled(),
                ),
        ];
    }

    // Поля для поиска
    public function search(): array
    {
        return [
            'date', 'driver.name',
            'num_liters_car_refueling', 'cost_car_refueling',
            'comment'
        ];
    }

    // Быстрые фильтры
    public function queryTags(): array
    {
        return [
            QueryTag::make(
                __('moonshine::refilling.all'),
                fn (Builder $query) => $query
            )->default(),
            QueryTag::make(
                __('moonshine::refilling.archive'),
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
        $settings = Valuestore::make(storage_path('app/settings.json'));

        $item->owner_id = Auth::user()->id;
        if (Auth::user()->moonshine_user_role_id == 3) {
            $item->driver_id = Auth::user()->id;
        }
        $item->price_car_refueling = $settings->get('price_car_refueling');
        $item->cost_car_refueling = $item->num_liters_car_refueling * $settings->get('price_car_refueling');
        return $item;
    }

    // Если запись сделана вручную, то она красная
    public function trAttributes(): Closure
    {
        return function (
            Model $item,
            int $row,
            ComponentAttributeBag $attr
        ): ComponentAttributeBag {
            if ($item->owner_id != 1) {
                $attr->setAttributes([
                    'class' => 'bgc-red'
                ]);
            }
            return $attr;
        };
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

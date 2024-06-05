<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Closure;
use App\Models\Refilling;
use MoonShine\Fields\Date;
use MoonShine\Fields\Field;
use MoonShine\Attributes\Icon;
use MoonShine\QueryTags\QueryTag;
use Illuminate\Support\Facades\Auth;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\ComponentAttributeBag;
use MoonShine\Fields\Relationships\BelongsTo;
use App\MoonShine\Pages\Refilling\RefillingFormPage;
use App\MoonShine\Pages\Refilling\RefillingIndexPage;
use App\MoonShine\Pages\Refilling\RefillingDetailPage;
use App\MoonShine\Resources\Sys\MoonShineUserResource;

/**
 * @extends ModelResource<Refilling>
 */
#[Icon('heroicons.outline.battery-50')]
class RefillingResource extends MainResource
{
    // Модель данных
    protected string $model = Refilling::class;

    // Поле сортировки по умолчанию
    protected string $sortColumn = 'date';

    // Тип сортировки по умолчанию
    protected string $sortDirection = 'DESC';

    // Количество элементов на странице
    protected int $itemsPerPage = 30;

    // Поле для отображения значений в связях и хлебных крошках
    public string $column = 'date';

    /**
     * getAlias
     * Устанавливает алиас для ресурса.
     * @return string
     */
    public function getAlias(): ?string
    {
        return __('moonshine::refilling.resource_page');
    }

    /**
     * title
     * Устанавливает заголовок для ресурса.
     * @return string
     */
    public function title(): string
    {
        return __('moonshine::refilling.refillings');
    }

    public function query(): Builder
    {
        if (Auth::user()->moonshine_user_role_id == 3)
            return parent::query()
                ->where('driver_id', Auth::user()->id)
                ->with('driver')
                ->with('petrolbrand')
                ->with('petrolstation')
                ->with('fuelcategory')
                ->with('truck');

        return parent::query()->with('driver')->with('petrolbrand')->with('petrolstation')->with('fuelcategory')->with('truck');
    }

    /**
     * pages
     *
     * @return array
     */
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

    /**
     * rules
     * Правила проверки вводимых данных
     * @param  mixed $item
     * @return array
     */
    public function rules(Model $item): array
    {
        return [
            'date' => ['required', 'date', 'before_or_equal:today'],
            'volume' => ['required', 'decimal:0,2', 'min:10', 'max:9999999.99'],
            'price' => ['required', 'decimal:0,2', 'min:10', 'max:9999999.99'],
            'sum' => ['required', 'decimal:0,2', 'min:10', 'max:9999999.99'],
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
            'volume', 'sum',
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

    /**
     * beforeCreating
     *
     * @param  mixed $item
     * @return Model
     */
    protected function beforeCreating(Model $item): Model
    {
        $item->owner_id = Auth::user()->id; // Запоминаем владельца
        // Если владелец водитель, то запоминаем водителя
        if (Auth::user()->moonshine_user_role_id == 3) {
            $item->driver_id = Auth::user()->id;
        }
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
}

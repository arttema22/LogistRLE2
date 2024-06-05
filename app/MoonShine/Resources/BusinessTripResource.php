<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use MoonShine\Fields\Date;
use MoonShine\Fields\Field;
use App\Models\BusinessTrip;
use MoonShine\Attributes\Icon;
use MoonShine\QueryTags\QueryTag;
use Illuminate\Support\Facades\Auth;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Resources\MoonShineUserResource;
use App\MoonShine\Pages\BusinessTrip\BusinessTripFormPage;
use App\MoonShine\Pages\BusinessTrip\BusinessTripIndexPage;
use App\MoonShine\Pages\BusinessTrip\BusinessTripDetailPage;

/**
 * @extends ModelResource<BusinessTrip>
 */
#[Icon('heroicons.outline.banknotes')]
class BusinessTripResource extends MainResource
{
    // Модель данных
    protected string $model = BusinessTrip::class;

    // Поле сортировки по умолчанию
    protected string $sortColumn = 'date';

    // Тип сортировки по умолчанию
    protected string $sortDirection = 'DESC';

    // Поле для отображения значений в связях и хлебных крошках
    public string $column = 'date';

    /**
     * getAlias
     * Устанавливает алиас для ресурса.
     * @return string
     */
    public function getAlias(): ?string
    {
        return __('moonshine::business.resource_page');
    }

    /**
     * title
     * Устанавливает заголовок для ресурса.
     * @return string
     */
    public function title(): string
    {
        return __('moonshine::business.business_trips');
    }

    /**
     * query
     *
     * @return Builder
     */
    public function query(): Builder
    {
        if (Auth::user()->moonshine_user_role_id == 3)
            return parent::query()
                ->where('driver_id', Auth::user()->id)
                ->with('driver');

        return parent::query()->with('driver');
    }

    /**
     * pages
     *
     * @return array
     */
    public function pages(): array
    {
        return [
            BusinessTripIndexPage::make($this->title()),
            BusinessTripFormPage::make(
                $this->getItemID()
                    ? __('moonshine::ui.edit')
                    : __('moonshine::ui.add')
            ),
            BusinessTripDetailPage::make(__('moonshine::ui.show')),
        ];
    }

    /**
     * rules
     *
     * @param  mixed $item
     * @return array
     */
    public function rules(Model $item): array
    {
        return [
            'date' => ['required', 'date', 'before_or_equal:today'],
            'sum' => ['required', 'decimal:0,2', 'min:10', 'max:9999999.99'],

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
        $item->owner_id = Auth::user()->id;
        if (Auth::user()->moonshine_user_role_id == 3) {
            $item->driver_id = Auth::user()->id;
        }
        return $item;
    }

    /**
     * filters
     *
     * @return array
     */
    public function filters(): array
    {
        return [
            Date::make('date', 'date')->translatable('moonshine::ui'),
            BelongsTo::make('driver', 'driver', resource: new MoonShineUserResource())
                ->valuesQuery(fn (Builder $query, Field $field) => $query->where('moonshine_user_role_id', 3))
                ->nullable()
                ->translatable('moonshine::ui')
                ->when(
                    Auth::user()->moonshine_user_role_id == 3,
                    fn (Field $field) => $field->disabled(),
                ),
        ];
    }

    /**
     * search
     *
     * @return array
     */
    public function search(): array
    {
        return [
            'date', 'driver.name', 'sum', 'comment'
        ];
    }

    /**
     * queryTags
     *
     * @return array
     */
    public function queryTags(): array
    {
        return [
            QueryTag::make(
                __('moonshine::ui.all'),
                fn (Builder $query) => $query
            )->default(),
            QueryTag::make(
                __('moonshine::ui.archive'),
                fn (Builder $query) => $query->onlyTrashed()
            ),

        ];
    }
}

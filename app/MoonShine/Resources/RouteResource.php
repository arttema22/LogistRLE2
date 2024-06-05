<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Route;
use MoonShine\Attributes\Icon;
use Illuminate\Support\Facades\Auth;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\MoonShine\Pages\Route\RouteFormPage;
use App\MoonShine\Pages\Route\RouteIndexPage;
use App\MoonShine\Pages\Route\RouteDetailPage;

/**
 * @extends ModelResource<Route>
 */
#[Icon('heroicons.outline.banknotes')]
class RouteResource extends MainResource
{
    // Модель данных
    protected string $model = Route::class;

    // Поле сортировки по умолчанию
    protected string $sortColumn = 'address_loading';

    // Тип сортировки по умолчанию
    protected string $sortDirection = 'ASC';

    // Поле для отображения значений в связях и хлебных крошках
    public string $column = 'address_loading';

    /**
     * getAlias
     * Устанавливает алиас для ресурса.
     * @return string
     */
    public function getAlias(): ?string
    {
        return __('moonshine::route.resource_list');
    }

    /**
     * title
     * Устанавливает заголовок для ресурса.
     * @return string
     */
    public function title(): string
    {
        return __('moonshine::route.routes');
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
                ->with('driver')->with('cargo');

        return parent::query()->with('driver')->with('cargo');
    }

    /**
     * pages
     *
     * @return array
     */
    public function pages(): array
    {
        return [
            RouteIndexPage::make($this->title()),
            RouteFormPage::make(
                $this->getItemID()
                    ? __('moonshine::ui.edit')
                    : __('moonshine::ui.add')
            ),
            RouteDetailPage::make(__('moonshine::ui.show')),
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
            'cargo_id' => ['required'],
            'address_loading' => ['required'],
            'address_unloading' => ['required'],
            'number_trips' => ['required'],
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
}

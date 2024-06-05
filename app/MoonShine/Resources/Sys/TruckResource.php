<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Sys;

use App\Models\Sys\Truck;
use MoonShine\Fields\Text;
use MoonShine\Attributes\Icon;
use MoonShine\QueryTags\QueryTag;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use App\MoonShine\Resources\MainResource;
use Illuminate\Database\Eloquent\Builder;
use MoonShine\Fields\Relationships\BelongsTo;
use App\MoonShine\Pages\Sys\Truck\TruckFormPage;
use App\MoonShine\Pages\Sys\Truck\TruckIndexPage;
use App\MoonShine\Resources\Dir\DirTruckTypeResource;
use App\MoonShine\Resources\Dir\DirTruckBrandResource;

/**
 * @extends ModelResource<Truck>
 */
#[Icon('heroicons.outline.truck')]
class TruckResource extends MainResource
{
    // Модель данных
    protected string $model = Truck::class;

    // Поле сортировки по умолчанию
    protected string $sortColumn = 'name';

    // Тип сортировки по умолчанию
    protected string $sortDirection = 'ASC';

    // Поле для отображения значений в связях и хлебных крошках
    public string $column = 'reg_num_ru';

    /**
     * getAlias
     * Устанавливает алиас для ресурса.
     * @return string
     */
    public function getAlias(): ?string
    {
        return __('moonshine::system.truck.resource_truck');
    }

    /**
     * title
     * Устанавливает заголовок для ресурса.
     * @return string
     */
    public function title(): string
    {
        return __('moonshine::system.truck.trucks');
    }

    /**
     * query
     *
     * @return Builder
     */
    public function query(): Builder
    {
        return parent::query()->with('brand')->with('type')->with('driver');
    }

    /**
     * pages
     *
     * @return array
     */
    public function pages(): array
    {
        return [
            TruckIndexPage::make($this->title()),
            TruckFormPage::make(
                $this->getItemID()
                    ? __('moonshine::ui.edit')
                    : __('moonshine::ui.add')
            ),
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
            'reg_num_ru' => ['required'],
            'reg_num_en' => ['required'],
        ];
    }


    /**
     * filters
     *
     * @return array
     */
    public function filters(): array
    {
        return [
            Text::make('name', 'name')->translatable('moonshine::system.truck'),
            BelongsTo::make('brand', 'brand', resource: new DirTruckBrandResource())
                ->nullable()
                ->translatable('moonshine::system.truck'),
            BelongsTo::make('type', 'type', resource: new DirTruckTypeResource())
                ->nullable()
                ->translatable('moonshine::system.truck'),
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
            'name', 'reg_num_ru', 'reg_num_en', 'brand.name',
            'type.name', 'users.name'
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
                __('moonshine::system.all'),
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
}

<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Closure;
use App\Models\Refilling;
use MoonShine\Enums\Layer;
use MoonShine\Fields\Date;
use MoonShine\Fields\Text;
use MoonShine\Fields\Field;
use MoonShine\Enums\PageType;
use MoonShine\Attributes\Icon;
use MoonShine\Fields\Position;
use MoonShine\Fields\StackFields;
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

/**
 * @extends ModelResource<Refilling>
 */
#[Icon('heroicons.outline.battery-50')]
class RefillingResource extends ModelResource
{
    // Модель данных
    protected string $model = Refilling::class;

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
        return __('moonshine::refilling.refillings');
    }

    // Разрешенные действия
    public function getActiveActions(): array
    {
        return [
            'create', // 'update', 'delete'
        ];
    }

    public function indexFields(): array
    {
        return [
            Position::make(),
            Date::make('date')->format('d.m.Y H:i')->sortable()
                ->translatable('moonshine::refilling'),
            BelongsTo::make('driver', 'driver', resource: new MoonShineUserResource())
                ->sortable()
                ->translatable('moonshine::refilling'),
            Text::make('num_liters_car_refueling')->badge('primary')
                ->sortable()
                ->translatable('moonshine::refilling'),
            Text::make('price_car_refueling')->translatable('moonshine::refilling'),
            Text::make('cost_car_refueling')
                ->sortable()
                ->translatable('moonshine::refilling'),
            BelongsTo::make(
                'stantion',
                'petrolStation',
                fn ($item) => "$item->name<br>$item->address",
                resource: new DirPetrolStationResource()
            )->translatable('moonshine::refilling'),
            BelongsTo::make(
                'truck',
                'truck',
                fn ($item) => "$item->name<br>$item->reg_num",
                resource: new DirPetrolStationResource()
            )->translatable('moonshine::refilling'),
        ];
    }

    public function formFields(): array
    {
        return [
            Date::make('date')->withTime()->required()
                ->translatable('moonshine::refilling'),
            BelongsTo::make('driver', 'driver', resource: new MoonShineUserResource())
                ->valuesQuery(fn (Builder $query, Field $field) => $query->where('moonshine_user_role_id', 3))
                ->translatable('moonshine::refilling'),
            BelongsTo::make(
                'petrol_station',
                'petrolStation',
                fn ($item) => "$item->name \ $item->address",
                resource: new DirPetrolStationResource()
            )->searchable()
                ->translatable('moonshine::refilling'),
            BelongsTo::make(
                'truck',
                'truck',
                fn ($item) => "$item->name \ $item->reg_num",
                resource: new TruckResource()
            )->searchable()
                ->nullable()
                ->translatable('moonshine::refilling'),
            Text::make('num_liters_car_refueling')->required()
                ->translatable('moonshine::refilling'),
        ];
    }

    public function rules(Model $item): array
    {
        return [
            'date' => ['required', 'date'],
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
                ->translatable('moonshine::refilling'),
        ];
    }

    // Поля для поиска
    public function search(): array
    {
        return [
            'date', 'driver.name',
            'num_liters_car_refueling', 'cost_car_refueling'
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

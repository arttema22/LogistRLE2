<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Closure;
use MoonShine\Fields\ID;
use App\Models\Refilling;
use MoonShine\Enums\Layer;
use MoonShine\Fields\Date;
use MoonShine\Fields\Text;
use MoonShine\Fields\Position;
use MoonShine\Fields\StackFields;
use Illuminate\Support\Facades\Auth;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\ComponentAttributeBag;
use MoonShine\ChangeLog\Components\ChangeLog;
use MoonShine\Fields\Relationships\BelongsTo;

/**
 * @extends ModelResource<Refilling>
 */
class RefillingResource extends ModelResource
{
    protected string $model = Refilling::class;

    protected bool $withPolicy = true; // Проверка прав доступа

    public function title(): string
    {
        return __('moonshine::refilling.refillings');
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

            StackFields::make('stantion')
                ->fields([
                    Text::make('brand')->translatable('moonshine::refilling'),
                    Text::make('address')->translatable('moonshine::refilling'),
                ])
                ->translatable('moonshine::refilling'),
        ];
    }

    public function formFields(): array
    {
        return [
            Date::make('date')->required(),
            // BelongsTo::make('owner_id', 'owner', resource: new MoonShineUserResource()),
            // BelongsTo::make('driver_id', 'driver', resource: new MoonShineUserResource())
            //     ->valuesQuery(fn ($query) => $query->where('moonshine_user_role_id', 3)),
            Text::make('num_liters_car_refueling')->required(),
        ];
    }

    public function detailFields(): array
    {
        return [
            ID::make()->sortable(),
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }

    protected function beforeCreating(Model $item): Model
    {
        //dd($item->toJson());
        $item->owner_id = Auth::user()->id;
        $item->price_car_refueling = 10;
        //$item->cost_car_refueling = $item->num_liters_car_refueling * $item->price_car_refueling;
        //dd($item->toJson());

        return $item;
    }

    // Если запись сделана через интеграцию, то она на зеленом фоне
    public function trAttributes(): Closure
    {
        return function (
            Model $item,
            int $row,
            ComponentAttributeBag $attr
        ): ComponentAttributeBag {
            if ($item->owner_id === 1) {
                $attr->setAttributes([
                    'class' => 'bgc-green'
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

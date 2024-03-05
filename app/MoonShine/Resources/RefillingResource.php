<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use MoonShine\Fields\ID;
use App\Models\Refilling;

use MoonShine\Enums\Layer;
use MoonShine\Fields\Date;
use MoonShine\Fields\Text;
use MoonShine\Fields\StackFields;
use MoonShine\Models\MoonshineUser;
use Illuminate\Support\Facades\Auth;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use MoonShine\ChangeLog\Components\ChangeLog;
use MoonShine\Fields\Relationships\BelongsTo;

/**
 * @extends ModelResource<Refilling>
 */
class RefillingResource extends ModelResource
{
    protected string $model = Refilling::class;

    protected string $title = 'Refillings';

    public function indexFields(): array
    {
        return [
            Date::make('date')->format('d.m.Y'),
            Text::make('driver_id'),
            Text::make('num_liters_car_refueling')->badge('primary'),
            Text::make('price_car_refueling'),
            Text::make('cost_car_refueling'),

            StackFields::make('brand')
                ->fields([
                    Text::make('brand')->translatable('moonshine::integration'),
                    Text::make('address')->translatable('moonshine::integration'),
                ])
                ->translatable('moonshine::refilling'),
        ];
    }

    public function formFields(): array
    {
        return [
            Date::make('date')->required(),
            // BelongsTo::make('owner_id', 'owner', resource: new MoonShineUserResource()),
            BelongsTo::make('driver_id', 'driver', resource: new MoonShineUserResource())
                ->valuesQuery(fn ($query) => $query->where('moonshine_user_role_id', 3)),
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

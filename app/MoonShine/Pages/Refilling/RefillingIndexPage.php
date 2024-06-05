<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Refilling;

use App\Models\Refilling;
use MoonShine\Fields\Date;
use MoonShine\Fields\Text;
use MoonShine\Fields\Field;
use Illuminate\Support\Number;
use MoonShine\Fields\Position;
use MoonShine\Components\Badge;
use MoonShine\Decorations\Flex;
use MoonShine\Fields\StackFields;
use MoonShine\Decorations\Divider;
use MoonShine\Pages\Crud\IndexPage;
use Illuminate\Support\Facades\Auth;
use MoonShine\Components\FlexibleRender;

class RefillingIndexPage extends IndexPage
{
    /**
     * getAlias
     *
     * @return string
     */
    public function getAlias(): ?string
    {
        return __('moonshine::refilling.index_page');
    }

    /**
     * fields
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Position::make(),
            Date::make('date')->format('d.m.Y H:i')->sortable()
                ->translatable('moonshine::refilling'),

            Text::make('driver', 'driver.name')
                ->when(
                    Auth::user()->moonshine_user_role_id == 3,
                    fn (Field $field) => $field->hideOnIndex()
                )
                ->translatable('moonshine::refilling'),

            StackFields::make('refilling')->fields([
                Text::make('volume', 'volume', fn ($item) => $item->volume . ' л.')->translatable('moonshine::refilling'),
                Text::make('price', 'price', fn ($item) => $item->price . ' р./л.')->translatable('moonshine::refilling'),
                Text::make('sum', 'sum', fn ($item) => $item->sum . ' руб.')->translatable('moonshine::refilling'),
            ])->translatable('moonshine::refilling'),

            StackFields::make('petrol_station')->fields([
                Text::make('petrolBrand.name'),
                Text::make('petrolStation.address'),
                Text::make('fuelCategory.name'),
            ])->translatable('moonshine::refilling'),

            StackFields::make('truck')->fields([
                Text::make('truck.name'),
                Text::make('truck.reg_num_ru'),
            ])->translatable('moonshine::refilling'),
        ];
    }

    /**
     * topLayer
     *
     * @return array
     */
    protected function topLayer(): array
    {
        if (Auth::user()->moonshine_user_role_id == 3) {
            // Водители
            $query = Refilling::where('driver_id', Auth::user()->id)->get();
        } else {
            // Админы и менеджеры
            $query = Refilling::all();
        }
        $count = $query->count();
        $sum = $query->sum('sum');

        return [
            Flex::make([
                FlexibleRender::make(__('moonshine::refilling.refilling_count') . ' ' . Badge::make(strval($count), 'info')),
                FlexibleRender::make(__('moonshine::refilling.refilling_sum') . ' ' . Badge::make(strval(Number::currency($sum, 'RUB')), 'info')),
            ])->justifyAlign('center')->itemsAlign('center'),
            Divider::make(),
            ...parent::topLayer(),
        ];
    }
}

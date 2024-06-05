<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Route;

use App\Models\Route;
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

class RouteIndexPage extends IndexPage
{
    /**
     * getAlias
     *
     * @return string
     */
    public function getAlias(): ?string
    {
        return __('moonshine::route.index_page');
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
            Date::make('date')->format('d.m.Y')->sortable()
                ->translatable('moonshine::route'),
            Text::make('driver.name')
                ->when(
                    Auth::user()->moonshine_user_role_id == 3,
                    fn (Field $field) => $field->hideOnIndex()
                )
                ->translatable('moonshine::route'),

            StackFields::make('route')->fields([
                Text::make('address_loading')->translatable('moonshine::route'),
                Text::make('address_unloading')->translatable('moonshine::route'),
            ])->translatable('moonshine::route'),

            Text::make('cargo.name')->translatable('moonshine::route'),

            Text::make('number_trips')->translatable('moonshine::route'),
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
            $query = Route::where('driver_id', Auth::user()->id)->get();
        } else {
            // Админы и менеджеры
            $query = Route::all();
        }
        $count = $query->count();

        return [
            Flex::make([
                FlexibleRender::make(__('moonshine::route.route_count') . ' ' . Badge::make(strval($count), 'info')),
            ])->justifyAlign('center')->itemsAlign('center'),
            Divider::make(),
            ...parent::topLayer(),
        ];
    }
}

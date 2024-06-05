<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\BusinessTrip;

use MoonShine\Fields\Date;
use MoonShine\Fields\Text;
use MoonShine\Fields\Field;
use App\Models\BusinessTrip;
use Illuminate\Support\Number;
use MoonShine\Fields\Position;
use MoonShine\Components\Badge;
use MoonShine\Decorations\Flex;
use MoonShine\Decorations\Divider;
use MoonShine\Pages\Crud\IndexPage;
use Illuminate\Support\Facades\Auth;
use MoonShine\Components\FlexibleRender;

class BusinessTripIndexPage extends IndexPage
{
    /**
     * getAlias
     *
     * @return string
     */
    public function getAlias(): ?string
    {
        return __('moonshine::business.index_page');
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
                ->translatable('moonshine::ui'),
            Text::make('driver.name')
                ->when(
                    Auth::user()->moonshine_user_role_id == 3,
                    fn (Field $field) => $field->hideOnIndex()
                )
                ->translatable('moonshine::ui'),
            Text::make('sum')->sortable()
                ->translatable('moonshine::ui'),
            Text::make('comment')
                ->translatable('moonshine::ui'),
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
            $query = BusinessTrip::where('driver_id', Auth::user()->id)->get();
        } else {
            // Админы и менеджеры
            $query = BusinessTrip::all();
        }
        $count = $query->count();
        $sum = $query->sum('sum');

        return [
            Flex::make([
                FlexibleRender::make(__('moonshine::business.business_count') . ' ' . Badge::make(strval($count), 'info')),
                FlexibleRender::make(__('moonshine::business.business_sum') . ' ' . Badge::make(strval(Number::currency($sum, 'RUB')), 'info')),
            ])->justifyAlign('center')->itemsAlign('center'),
            Divider::make(),
            ...parent::topLayer(),
        ];
    }
}

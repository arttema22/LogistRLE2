<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Service;

use App\Models\Service;
use MoonShine\Fields\Date;
use MoonShine\Fields\Text;
use MoonShine\Fields\Field;
use Illuminate\Support\Number;
use MoonShine\Fields\Checkbox;
use MoonShine\Fields\Position;
use MoonShine\Components\Badge;
use MoonShine\Decorations\Flex;
use MoonShine\Decorations\Divider;
use MoonShine\Decorations\Heading;
use MoonShine\Pages\Crud\IndexPage;
use Illuminate\Support\Facades\Auth;
use MoonShine\Components\FlexibleRender;

class ServiceIndexPage extends IndexPage
{
    /**
     * getAlias
     *
     * @return string
     */
    public function getAlias(): ?string
    {
        return __('moonshine::service.index_page');
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
            Text::make('name', 'service.name')->translatable('moonshine::ui'),
            Text::make('price', 'service.tariff.price')->translatable('moonshine::ui'),
            Checkbox::make('is_route')->translatable('moonshine::ui'),
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
            $query = Service::where('driver_id', Auth::user()->id)->get();
        } else {
            // Админы и менеджеры
            $query = Service::all();
        }
        $count = $query->count();

        return [
            Flex::make([
                FlexibleRender::make(__('moonshine::service.service_count') . ' ' . Badge::make(strval($count), 'info')),
            ])->justifyAlign('center')->itemsAlign('center'),
            Divider::make(),
            ...parent::topLayer(),
        ];
    }
}

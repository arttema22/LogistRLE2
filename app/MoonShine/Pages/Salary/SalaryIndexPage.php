<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Salary;

use App\Models\Salary;
use MoonShine\Fields\Date;
use MoonShine\Fields\Text;
use MoonShine\Fields\Field;
use Illuminate\Support\Number;
use MoonShine\Fields\Position;
use MoonShine\Components\Badge;
use MoonShine\Decorations\Flex;
use MoonShine\Decorations\Divider;
use MoonShine\Pages\Crud\IndexPage;
use Illuminate\Support\Facades\Auth;
use MoonShine\Components\FlexibleRender;

class SalaryIndexPage extends IndexPage
{
    /**
     * getAlias
     *
     * @return string
     */
    public function getAlias(): ?string
    {
        return __('moonshine::salary.index_page');
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
            $query = Salary::where('driver_id', Auth::user()->id)->get();
        } else {
            // Админы и менеджеры
            $query = Salary::all();
        }
        $count = $query->count();
        $sum = $query->sum('sum');

        return [
            Flex::make([
                FlexibleRender::make(__('moonshine::salary.salary_count') . ' ' . Badge::make(strval($count), 'info')),
                FlexibleRender::make(__('moonshine::salary.salary_sum') . ' ' . Badge::make(strval(Number::currency($sum, 'RUB')), 'info')),
            ])->justifyAlign('center')->itemsAlign('center'),
            Divider::make(),
            ...parent::topLayer(),
        ];
    }
}

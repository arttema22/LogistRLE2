<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Profit;

use MoonShine\Fields\Date;
use MoonShine\Fields\Text;
use MoonShine\Fields\Field;
use MoonShine\Fields\Position;
use MoonShine\Pages\Crud\IndexPage;
use Illuminate\Support\Facades\Auth;
use MoonShine\Fields\Relationships\BelongsTo;
use App\MoonShine\Resources\Sys\MoonShineUserResource;

class ProfitIndexPage extends IndexPage
{
    /**
     * getAlias
     *
     * @return string
     */
    public function getAlias(): ?string
    {
        return __('moonshine::profit.index_page');
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
                ->translatable('moonshine::refilling'),
            Text::make('driver.name')
                ->when(
                    Auth::user()->moonshine_user_role_id == 3,
                    fn (Field $field) => $field->hideOnIndex()
                )
                ->sortable()->translatable('moonshine::profit'),
            Text::make('title')->sortable()->translatable('moonshine::profit'),
            Text::make('comment')->translatable('moonshine::profit'),
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Service;

use MoonShine\Fields\Date;
use MoonShine\Fields\Text;
use MoonShine\Fields\Field;
use MoonShine\Fields\Checkbox;
use MoonShine\Fields\Textarea;
use MoonShine\Decorations\Flex;
use MoonShine\Decorations\Block;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\MoonShine\Resources\RouteResource;
use App\MoonShine\Pages\Crud\FormPageCustom;
use MoonShine\Fields\Relationships\BelongsTo;
use App\MoonShine\Resources\Dir\DirServiceResource;
use App\MoonShine\Resources\Sys\MoonShineUserResource;

class ServiceFormPage extends FormPageCustom
{
    /**
     * getAlias
     *
     * @return string
     */
    public function getAlias(): ?string
    {
        return __('moonshine::service.form_page');
    }

    /**
     * fields
     *
     * @return array
     */
    public function fields(): array
    {
        return [

            Block::make([
                BelongsTo::make('driver', 'driver', resource: new MoonShineUserResource())
                    ->valuesQuery(fn (Builder $query, Field $field) => $query->where('moonshine_user_role_id', 3))
                    ->required()
                    ->nullable()
                    ->searchable()
                    ->translatable('moonshine::ui')
                    ->when(
                        fn () => Auth::user()->moonshine_user_role_id == 3,
                        fn (Field $field) => $field->hideOnForm(),
                    ),

                Checkbox::make('is_route')->translatable('moonshine::ui'),

                Flex::make([
                    Date::make('date')
                        ->translatable('moonshine::ui')
                        ->showWhen('is_route', 0),

                    BelongsTo::make(
                        'route',
                        'route',
                        fn ($item) => "$item->date() . ' ' . $item->address_unloading . ' - ' . $item->address_loading",
                        resource: new RouteResource()
                    )
                        ->nullable()
                        ->searchable()
                        ->translatable('moonshine::ui')
                        ->showWhen('is_route', 1),

                    BelongsTo::make('service', 'service', resource: new DirServiceResource())
                        ->required()
                        ->nullable()
                        ->translatable('moonshine::ui'),
                ]),

                Text::make('comment')->translatable('moonshine::ui'),
            ]),
        ];
    }
}

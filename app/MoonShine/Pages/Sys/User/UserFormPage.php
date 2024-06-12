<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Sys\User;

use MoonShine\Fields\Text;
use MoonShine\Fields\Email;
use MoonShine\Fields\Phone;
use MoonShine\Fields\Password;
use MoonShine\Decorations\Block;
use App\Models\Sys\MoonshineUserRole;
use App\MoonShine\Pages\Crud\FormPageCustom;
use MoonShine\Fields\Relationships\BelongsTo;
use App\MoonShine\Resources\Sys\MoonShineUserRoleResource;

class UserFormPage extends FormPageCustom
{
    /**
     * getAlias
     * Устанавливает алиас для ресурса.
     * @return string
     */
    public function getAlias(): ?string
    {
        return __('moonshine::system.resource_form');
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
                Text::make('surname', 'profile.surname')
                    ->required()
                    ->translatable('moonshine::ui.resource'),

                Text::make('name', 'profile.name')
                    ->required()
                    ->translatable('moonshine::ui.resource'),

                Text::make('patronymic', 'profile.patronymic')
                    ->translatable('moonshine::ui.resource'),

                BelongsTo::make(
                    __('moonshine::ui.resource.role'),
                    'moonshineUserRole',
                    static fn (MoonshineUserRole $model) => $model->name,
                    new MoonShineUserRoleResource(),
                ),
                Email::make(__('moonshine::ui.resource.email'), 'email')
                    ->required(),

                Phone::make('phone', 'profile.phone')
                    ->translatable('moonshine::ui.resource')
                    ->required(),

                Text::make('e1_card', 'profile.e1_card')
                    ->translatable('moonshine::ui.resource'),

                Text::make('saldo_start', 'profit.saldo_start')
                    ->translatable('moonshine::ui.resource'),

                Password::make(__('moonshine::ui.resource.password'), 'password')
                    ->customAttributes(['autocomplete' => 'new-password'])
                    ->eye(),

            ]),
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Sys\User;

use MoonShine\Fields\Text;
use MoonShine\Fields\Email;
use MoonShine\Fields\Phone;
use MoonShine\MoonShineAuth;
use MoonShine\Decorations\Tab;
use MoonShine\Fields\Password;
use MoonShine\Decorations\Grid;
use MoonShine\Decorations\Tabs;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Heading;
use MoonShine\TypeCasts\ModelCast;
use MoonShine\Fields\PasswordRepeat;
use App\Models\Sys\MoonshineUserRole;
use MoonShine\Components\FormBuilder;
use App\MoonShine\Pages\Crud\FormPageCustom;
use App\MoonShine\Controllers\UserController;
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
            Tabs::make([
                Tab::make(__('moonshine::ui.resource.main_information'), [
                    Grid::make([
                        Column::make([
                            Block::make([
                                Text::make('surname', 'profile.surname')
                                    ->required()
                                    ->translatable('moonshine::ui.resource'),

                                Text::make('name', 'profile.name')
                                    ->required()
                                    ->translatable('moonshine::ui.resource'),

                                Text::make('patronymic', 'profile.patronymic')
                                    ->translatable('moonshine::ui.resource'),
                            ]),
                        ])->columnSpan(6),
                        Column::make([
                            Block::make([
                                Email::make(__('moonshine::ui.resource.email'), 'email')
                                    ->required(),

                                Phone::make('phone', 'profile.phone')
                                    ->translatable('moonshine::ui.resource'),
                            ]),
                        ])->columnSpan(6),
                        Column::make([
                            Block::make([
                                BelongsTo::make(
                                    __('moonshine::ui.resource.role'),
                                    'moonshineUserRole',
                                    static fn (MoonshineUserRole $model) => $model->name,
                                    new MoonShineUserRoleResource(),
                                ),

                                Text::make('e1_card', 'profile.e1_card')
                                    ->translatable('moonshine::ui.resource'),

                                Text::make('saldo_start', 'profit.saldo_start')
                                    ->translatable('moonshine::ui.resource'),
                            ]),
                        ])->columnSpan(6),
                    ]),
                ]),
                Tab::make(__('moonshine::ui.resource.password'), [
                    Block::make([
                        Heading::make(__('moonshine::ui.resource.change_password')),
                        Password::make(trans('moonshine::ui.resource.password'), 'password')
                            ->customAttributes(['autocomplete' => 'new-password'])
                            ->eye(),
                        PasswordRepeat::make(trans('moonshine::ui.resource.repeat_password'), 'password_repeat')
                            ->customAttributes(['autocomplete' => 'confirm-password'])
                            ->eye(),
                    ]),
                ]),
            ]),
        ];
    }

    public function components(): array
    {
        return [
            FormBuilder::make(action([UserController::class, 'storeProfile']))
                ->customAttributes([
                    'enctype' => 'multipart/form-data',
                ])
                ->fields($this->fields())
                ->cast(ModelCast::make(MoonShineAuth::model()::class))
                ->submit(__('moonshine::ui.save'), [
                    'class' => 'btn-lg btn-primary',
                ]),
        ];
    }
}

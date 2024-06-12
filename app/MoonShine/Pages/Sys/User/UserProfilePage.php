<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Sys\User;

use MoonShine\Pages\Page;
use MoonShine\Fields\Text;
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
use MoonShine\Components\FormBuilder;
use MoonShine\Components\MoonShineComponent;
use App\MoonShine\Controllers\UserController;

class UserProfilePage extends Page
{
    /**
     * @return array<string, string>
     */
    public function breadcrumbs(): array
    {
        return [
            '#' => $this->title(),
        ];
    }

    public function title(): string
    {
        return __('moonshine::ui.profile');
    }

    public function fields(): array
    {
        return [
            Tabs::make([
                Tab::make(__('moonshine::ui.resource.main_information'), [
                    Grid::make([
                        Column::make([
                            Block::make([
                                Text::make('surname')
                                    ->setValue(
                                        auth()->user()->profile
                                            ->{config('moonshine.auth.fields.surname', 'surname')}
                                    )
                                    ->required()
                                    ->translatable('moonshine::ui.resource'),

                                Text::make('name')
                                    ->setValue(
                                        auth()->user()->profile
                                            ->{config('moonshine.auth.fields.name', 'name')}
                                    )
                                    ->required()
                                    ->translatable('moonshine::ui.resource'),

                                Text::make('patronymic')
                                    ->setValue(
                                        auth()->user()->profile
                                            ->{config('moonshine.auth.fields.patronymic', 'patronymic')}
                                    )
                                    ->translatable('moonshine::ui.resource'),
                            ]),
                        ])->columnSpan(6),
                        Column::make([
                            Block::make([
                                Text::make('phone')
                                    ->setValue(
                                        auth()->user()->profile
                                            ->{config('moonshine.auth.fields.phone', 'phone')}
                                    )
                                    ->translatable('moonshine::ui.resource'),

                                Text::make('e1_card', 'e1_card')
                                    ->setValue(
                                        auth()->user()->profile
                                            ->{config('moonshine.auth.fields.e1_card', 'e1_card')}
                                    )
                                    ->translatable('moonshine::ui.resource'),

                                Text::make(trans('moonshine::ui.login.email'), 'email')
                                    ->setValue(auth()->user()
                                        ->{config('moonshine.auth.fields.email', 'email')})
                                    ->required(),
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

    /**
     * @return list<MoonShineComponent>
     */
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

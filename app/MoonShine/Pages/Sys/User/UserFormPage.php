<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Sys\User;

use MoonShine\Fields\ID;
use MoonShine\Fields\Date;
use MoonShine\Fields\Text;
use MoonShine\Fields\Email;
use MoonShine\Fields\Phone;
use MoonShine\Decorations\Tab;
use MoonShine\Fields\Password;
use MoonShine\Decorations\Tabs;
use MoonShine\Decorations\Block;
use MoonShine\Fields\StackFields;
use MoonShine\Decorations\Heading;
use MoonShine\Fields\PasswordRepeat;
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
                Tabs::make([
                    Tab::make(__('moonshine::ui.resource.main_information'), [
                        ID::make()
                            ->sortable()
                            ->showOnExport()
                            ->hideOnIndex(),

                        Text::make(__('moonshine::ui.resource.name'), 'name')
                            ->required()
                            ->sortable()
                            ->showOnExport(),

                        BelongsTo::make(
                            __('moonshine::ui.resource.role'),
                            'moonshineUserRole',
                            static fn (MoonshineUserRole $model) => $model->name,
                            new MoonShineUserRoleResource(),
                        )
                            ->sortable()
                            ->badge('purple'),

                        // Image::make(__('moonshine::ui.resource.avatar'), 'avatar')
                        //     ->showOnExport()
                        //     ->disk(config('moonshine.disk', 'public'))
                        //     ->dir('moonshine_users')
                        //     ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif']),

                        Date::make(__('moonshine::ui.resource.created_at'), 'created_at')
                            ->format("d.m.Y")
                            ->default(now()->toDateTimeString())
                            ->sortable()
                            ->hideOnForm()
                            ->hideOnIndex()
                            ->showOnExport(),

                        StackFields::make('email/phone')->fields([
                            Email::make(__('moonshine::ui.resource.email'), 'email')
                                ->sortable()
                                ->showOnExport()
                                ->required(),
                            Phone::make('phone')
                                //->mask('+7(999) 999-99-99')
                                ->translatable('moonshine::ui.resource')
                                ->sortable()
                                ->showOnExport()
                                ->required(),
                        ])->translatable('moonshine::ui.resource'),
                        Text::make('e1_card')
                            ->sortable()
                            ->showOnExport()
                            ->translatable('moonshine::ui.resource'),
                    ]),

                    Tab::make(__('moonshine::ui.resource.password'), [
                        Heading::make(__('moonshine::system.user.change_password')),

                        Password::make(__('moonshine::ui.resource.password'), 'password')
                            ->customAttributes(['autocomplete' => 'new-password'])
                            ->hideOnIndex()
                            ->eye(),

                        PasswordRepeat::make(__('moonshine::ui.resource.repeat_password'), 'password_repeat')
                            ->customAttributes(['autocomplete' => 'confirm-password'])
                            ->hideOnIndex()
                            ->eye(),
                    ]),
                ]),
            ]),
        ];
    }
}

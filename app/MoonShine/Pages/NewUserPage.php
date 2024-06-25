<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use App\MoonShine\Controllers\UserController;
use MoonShine\Pages\Page;
use MoonShine\Fields\Text;
use MoonShine\Fields\Email;
use MoonShine\Fields\Phone;
use MoonShine\Fields\Select;
use MoonShine\Fields\Password;
use MoonShine\Decorations\Grid;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Fields\PasswordRepeat;
use MoonShine\Components\FormBuilder;
use MoonShine\Models\MoonshineUserRole;

class NewUserPage extends Page
{
    /**
     * @return array<string, string>
     */
    public function breadcrumbs(): array
    {
        return [
            '#' => $this->title()
        ];
    }

    public function title(): string
    {
        return $this->title ?: 'NewUserPage';
    }

    public function fields(): array
    {
        $role = MoonshineUserRole::all('id', 'name')->pluck('name', 'id')->toArray();

        return [
            Grid::make([
                Column::make([
                    Block::make([
                        Text::make('surname')
                            //->required()
                            ->translatable('moonshine::ui.resource'),
                        Text::make('name')
                            //->required()
                            ->translatable('moonshine::ui.resource'),
                        Text::make('patronymic')
                            ->translatable('moonshine::ui.resource'),
                    ]),
                ])->columnSpan(6),
                Column::make([
                    Block::make([
                        Select::make('role')
                            //->required()
                            ->options($role)
                            ->translatable('moonshine::ui.resource'),
                        Password::make('password')
                            //->required()
                            ->translatable('moonshine::ui.resource')
                            ->customAttributes(['autocomplete' => 'new-password'])
                            ->eye(),
                        PasswordRepeat::make(trans('moonshine::ui.resource.repeat_password'), 'password_repeat')
                            ->customAttributes(['autocomplete' => 'confirm-password'])
                            ->eye(),
                    ]),
                ])->columnSpan(6),
                Column::make([
                    Block::make([
                        Email::make('email')
                            //->required()
                            ->translatable('moonshine::ui.resource'),
                        Phone::make('phone')
                            ->translatable('moonshine::ui.resource'),
                    ]),
                ])->columnSpan(6),
                Column::make([
                    Block::make([
                        Text::make('e1_card')
                            ->translatable('moonshine::ui.resource'),
                        Text::make('saldo_start')
                            ->translatable('moonshine::ui.resource'),
                    ]),
                ])->columnSpan(6),
            ]),
        ];
    }

    /**
     * @return list<MoonShineComponent>
     */
    public function components(): array
    {
        return [
            FormBuilder::make(action([UserController::class, 'store']))
                ->method('POST')
                ->fields($this->fields())
                ->fill([])
                ->name('new-user'),
        ];
    }
}

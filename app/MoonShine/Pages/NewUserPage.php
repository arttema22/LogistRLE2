<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use MoonShine\Pages\Page;
use MoonShine\Fields\Text;
use MoonShine\Fields\Email;
use MoonShine\Fields\Phone;
use MoonShine\Fields\Password;
use MoonShine\Components\FormBuilder;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Grid;
use MoonShine\Models\MoonshineUserRole;
use MoonShine\Fields\Select;

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

    /**
     * @return list<MoonShineComponent>
     */
    public function components(): array
    {
        $role = MoonshineUserRole::all('id', 'name')->pluck('name', 'id')->toArray();

        return [
            FormBuilder::make()
                ->action(route('user.store'))
                ->method('POST')
                ->fields([
                    Grid::make([
                        Column::make([
                            Block::make([
                                Text::make('surname')
                                    ->required()
                                    ->translatable('moonshine::ui.resource'),
                                Text::make('name')
                                    ->required()
                                    ->translatable('moonshine::ui.resource'),
                                Text::make('patronymic')
                                    ->translatable('moonshine::ui.resource'),
                                Select::make('role')
                                    ->required()
                                    ->options($role)
                                    ->translatable('moonshine::ui.resource'),
                                Email::make('email')
                                    ->required()
                                    ->translatable('moonshine::ui.resource'),
                                Password::make('password')
                                    ->required()
                                    ->translatable('moonshine::ui.resource')
                                    ->customAttributes(['autocomplete' => 'new-password'])
                                    ->eye(),
                            ]),
                        ])->columnSpan(6),
                        Column::make([
                            Phone::make('phone')
                                ->translatable('moonshine::ui.resource'),
                            Text::make('e1_card')
                                ->translatable('moonshine::ui.resource'),
                            Text::make('saldo_start')
                                ->translatable('moonshine::ui.resource'),
                        ])->columnSpan(6),
                    ]),
                ])
                ->fill([])
                ->name('new-user'),
        ];
    }
}

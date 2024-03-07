<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use MoonShine\Pages\Page;
use MoonShine\Fields\Text;
use MoonShine\Decorations\Block;
use Spatie\Valuestore\Valuestore;
use MoonShine\Components\FormBuilder;
use MoonShine\Components\TableBuilder;
use Illuminate\Database\Eloquent\Collection;

class Settings extends Page
{
    public function breadcrumbs(): array
    {
        return [
            '#' => $this->title()
        ];
    }

    public function title(): string
    {
        return $this->title ?: 'Settings';
    }

    public function components(): array
    {
        $settings = Valuestore::make(storage_path('app/settings.json'));

        return [
            Block::make([
                FormBuilder::make()
                    ->action(route('settings.store'))
                    ->method('POST')
                    ->fields([
                        Text::make('price_car_refueling'),
                    ])
                    ->fill([
                        'price_car_refueling' => $settings->get('price_car_refueling'),
                    ])
                    ->name('setup-form'),
            ]),
        ];
    }
}

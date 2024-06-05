<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Sys;

use MoonShine\Pages\Page;
use MoonShine\Decorations\Block;
use Spatie\Valuestore\Valuestore;
use MoonShine\Components\FormBuilder;
use MoonShine\Fields\Number;

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
        return __('moonshine::setup.settings');
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
                        Number::make('price_car_refueling')->step(.01)->translatable('moonshine::setup'),
                    ])
                    ->fill([
                        'price_car_refueling' => $settings->get('price_car_refueling'),
                    ])
                    ->name('setup-form'),
            ]),
        ];
    }
}

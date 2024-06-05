<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use App\Models\Refilling;
use MoonShine\Pages\Page;
use MoonShine\Fields\Date;
use MoonShine\Fields\Text;
use MoonShine\Fields\Field;
use Illuminate\Support\Carbon;
use MoonShine\Components\Card;
use MoonShine\Fields\Password;
use MoonShine\Fields\Position;
use MoonShine\Components\Modal;
use App\Models\Sys\MoonshineUser;
use MoonShine\Fields\StackFields;
use Carbon\Carbon as CarbonCarbon;
use MoonShine\Decorations\Heading;
use MoonShine\Metrics\ValueMetric;
use MoonShine\TypeCasts\ModelCast;
use MoonShine\Pages\PageComponents;
use Illuminate\Support\Facades\Auth;
use MoonShine\Components\FormBuilder;
use MoonShine\Components\CardsBuilder;
use MoonShine\Components\TableBuilder;
use MoonShine\ActionButtons\ActionButton;
use App\MoonShine\Resources\RouteResource;
use App\MoonShine\Resources\SalaryResource;
use MoonShine\Fields\Relationships\HasMany;
use App\MoonShine\Resources\RefillingResource;

class Profit extends Page
{
    public function breadcrumbs(): array
    {
        return [
            '#' => $this->title()
        ];
    }

    public function title(): string
    {
        return $this->title ?: 'Profit';
    }

    public function components(): array
    {
        return [
            TableBuilder::make(items: MoonshineUser::where('moonshine_user_role_id', 3)->get())
                ->fields([
                    Text::make('', 'name')
                        ->when(
                            Auth::user()->moonshine_user_role_id == 3,
                            fn (Field $field) => $field->hideOnIndex()
                        )
                        ->sortable(),
                    //->translatable('moonshine::profit'),
                    HasMany::make('', 'profits')
                        ->fields([
                            Text::make('saldo_end'),
                        ]),

                    // Заправки

                    HasMany::make('refillings', resource: new RefillingResource())
                        ->onlyLink()->translatable('moonshine::refilling'),

                    HasMany::make('refillings', resource: new RefillingResource())
                        ->fields([
                            Date::make('date')->format('d.m.Y')
                                ->translatable('moonshine::refilling'),
                            Text::make(
                                'data',
                                'data',
                                fn ($item) => $item->volume . 'л. * '
                                    . $item->price . 'р. = ' . $item->sum . 'р.'
                            )->translatable('moonshine::refilling'),
                            StackFields::make('stantion')->fields([
                                Text::make('petrolStation.petrolStationBrand.name'),
                                Text::make('petrolStation.address'),
                            ])->translatable('moonshine::refilling'),
                            Text::make('fuel', 'fuelType.fuelCategory.name')
                                ->translatable('moonshine::refilling'),
                            StackFields::make('truck')->fields([
                                Text::make('truck.name'),
                                Text::make('truck.reg_num_ru'),
                            ])->translatable('moonshine::refilling'),
                        ])->translatable('moonshine::refilling'),



                    HasMany::make('salaries', resource: new SalaryResource())
                        ->fields([
                            Text::make(
                                'data',
                                'data',
                                fn ($item) => Carbon::parse($item->date)->format('d.m.Y') . ' - ' . $item->salary . 'р.'
                            ),
                        ]),
                    HasMany::make('routes', resource: new RouteResource())
                        ->fields([
                            Text::make(
                                'data',
                                'data',
                                fn ($item) => Carbon::parse($item->date)->format('d.m.Y') . ' ' . $item->address_loading . ' - ' . $item->address_unloading
                            ),
                        ]),
                ])
                ->withNotFound()
                ->cast(ModelCast::make(MoonshineUser::class))
                ->vertical(),
        ];
    }
}

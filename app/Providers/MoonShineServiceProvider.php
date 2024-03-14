<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\DirPetrolStation;
use App\Models\Refilling;
use MoonShine\MoonShine;
use Illuminate\Http\Request;
use MoonShine\Menu\MenuItem;
use MoonShine\Menu\MenuGroup;
use App\Models\SetupIntegration;
use App\MoonShine\Pages\E1card;
use App\MoonShine\Pages\Monopoly;
use App\MoonShine\Pages\Settings;
use App\MoonShine\Resources\DirPetrolStationResource;
use App\MoonShine\Resources\DirTruckBrandResource;
use App\MoonShine\Resources\DirTruckTypeResource;
use App\MoonShine\Resources\MoonShineUserResource;
use App\MoonShine\Resources\SetupIntegrationResource;
use App\MoonShine\Resources\MoonShineUserRoleResource;
use App\MoonShine\Resources\ProfileResource;
use App\MoonShine\Resources\RefillingResource;
use App\MoonShine\Resources\SalaryResource;
use App\MoonShine\Resources\TruckResource;
use MoonShine\Decorations\Divider;
use MoonShine\Menu\MenuDivider;
use MoonShine\Providers\MoonShineApplicationServiceProvider;

class MoonShineServiceProvider extends MoonShineApplicationServiceProvider
{
    protected function resources(): array
    {
        return [];
    }

    protected function pages(): array
    {
        return [];
    }

    protected function menu(): array
    {
        return [
            MenuItem::make('refillings', new RefillingResource())
                ->translatable('moonshine::refilling'),

            MenuItem::make('salaries', new SalaryResource())
                ->translatable('moonshine::salary'),

            MenuItem::make('trucks', new TruckResource())
                ->translatable('moonshine::truck'),

            MenuGroup::make(static fn () => __('moonshine::ui.resource.system'), [
                MenuItem::make(
                    static fn () => __('moonshine::ui.resource.role_title'),
                    new MoonShineUserRoleResource()
                ),

                MenuItem::make('settings', new Settings())->icon('heroicons.cog-6-tooth')
                    ->translatable('moonshine::setup'),
            ]),

            MenuGroup::make(static fn () => __('moonshine::integration.integrations'), [
                MenuItem::make('e1card', new E1card())->icon('heroicons.arrows-right-left')
                    ->translatable('moonshine::integration'),
                MenuItem::make('monopoly', new Monopoly())->icon('heroicons.arrows-right-left')
                    ->translatable('moonshine::integration'),
                MenuDivider::make()->canSee(function (Request $request) {
                    return $request->user('moonshine')?->moonshine_user_role_id == 1;
                }),
                MenuItem::make(
                    static fn () => __('moonshine::integration.set_up'),
                    new SetupIntegrationResource()
                )->canSee(function (Request $request) {
                    return $request->user('moonshine')?->moonshine_user_role_id == 1;
                }),
            ])->icon('heroicons.arrows-right-left'),

            MenuGroup::make('directories', [
                MenuDivider::make('trucks')->translatable('moonshine::truck'),
                MenuItem::make('brands', new DirTruckBrandResource())
                    ->translatable('moonshine::directory'),
                MenuItem::make('types', new DirTruckTypeResource())
                    ->translatable('moonshine::directory'),
                MenuDivider::make('petrol_station')->translatable('moonshine::directory'),
                MenuItem::make('petrol_station', new DirPetrolStationResource())
                    ->translatable('moonshine::directory'),
            ])->icon('heroicons.bars-3')
                ->translatable('moonshine::directory'),


            MenuItem::make(
                static fn () => __('moonshine::ui.resource.title'),
                new MoonShineUserResource()
            ),

            MenuItem::make('help', 'https://github.com/arttema22/LogistRLE2/wiki', blank: true)
                ->icon('heroicons.outline.lifebuoy')
                ->translatable('moonshine::ui'),
        ];
    }

    /**
     * @return array{css: string, colors: array, darkColors: array}
     */
    protected function theme(): array
    {
        return [
            'colors' => [
                'primary' => 'rgb(42, 69, 35)', // темно зеленый
                'secondary' => 'rgb(42, 69, 35)', // темно зеленый
                'body' => 'rgb(27, 37, 59)',
                //'body' => 'rgb(93, 160, 53)', // светло зеленый
            ],
        ];
    }
}

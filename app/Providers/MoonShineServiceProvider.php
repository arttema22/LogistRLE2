<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Http\Request;
use MoonShine\Menu\MenuItem;
use MoonShine\Menu\MenuGroup;
use App\MoonShine\Pages\E1card;
use MoonShine\Menu\MenuDivider;
use App\MoonShine\Pages\Monopoly;
use App\MoonShine\Pages\Sys\Settings;
use App\MoonShine\Resources\Sys\TruckResource;
use App\MoonShine\Resources\SalaryResource;
use App\MoonShine\Resources\RefillingResource;
use App\MoonShine\Resources\Dir\DirCargoResource;
use App\MoonShine\Resources\Sys\MoonShineUserResource;
use App\MoonShine\Resources\Dir\DirServiceResource;
use App\MoonShine\Resources\Dir\DirFuelTypeResource;
use App\MoonShine\Resources\Dir\DirTruckTypeResource;
use App\MoonShine\Resources\Sys\SetupIntegrationResource;
use App\MoonShine\Resources\Dir\DirTruckBrandResource;
use App\MoonShine\Resources\Sys\MoonShineUserRoleResource;
use App\MoonShine\Resources\Dir\DirFuelCategoryResource;
use App\MoonShine\Resources\Dir\DirPetrolStationResource;
use MoonShine\Providers\MoonShineApplicationServiceProvider;
use App\MoonShine\Resources\Dir\DirPetrolStationBrandResource;

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

            MenuGroup::make(static fn () => __('moonshine::ui.resource.system'), [
                MenuItem::make('trucks', new TruckResource())
                    ->translatable('moonshine::system.truck'),
                MenuItem::make(
                    static fn () => __('moonshine::system.role.roles'),
                    new MoonShineUserRoleResource()
                ),
                MenuItem::make(
                    static fn () => __('moonshine::system.user.users'),
                    new MoonShineUserResource()
                ),
                MenuItem::make('settings', new Settings())->icon('heroicons.cog-6-tooth')
                    ->translatable('moonshine::setup'),
                MenuItem::make(
                    static fn () => __('moonshine::integration.set_up'),
                    new SetupIntegrationResource()
                )->canSee(function (Request $request) {
                    return $request->user('moonshine')?->moonshine_user_role_id == 1;
                }),
            ]),

            MenuGroup::make('directories', [
                MenuItem::make('cargos', new DirCargoResource())
                    ->translatable('moonshine::directory'),
                MenuItem::make('services', new DirServiceResource())
                    ->translatable('moonshine::directory'),
                MenuDivider::make('trucks')->translatable('moonshine::truck'),
                MenuItem::make('brands', new DirTruckBrandResource())
                    ->translatable('moonshine::directory'),
                MenuItem::make('types', new DirTruckTypeResource())
                    ->translatable('moonshine::directory'),
                MenuDivider::make('petrol_station')->translatable('moonshine::directory'),
                MenuItem::make('petrol_station_brands', new DirPetrolStationBrandResource())
                    ->translatable('moonshine::directory'),
                MenuItem::make('petrol_station', new DirPetrolStationResource())
                    ->translatable('moonshine::directory'),
                MenuItem::make('fuels', new DirFuelTypeResource())
                    ->translatable('moonshine::directory'),
                MenuItem::make('fuel_categories', new DirFuelCategoryResource())
                    ->translatable('moonshine::directory'),
            ])->icon('heroicons.bars-3')
                ->translatable('moonshine::directory'),

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

<?php

declare(strict_types=1);

namespace App\Providers;

use App\MoonShine\Pages\DirFuelCategoryFormPage;
use App\MoonShine\Pages\fresh1c\contract1cPage;
use App\MoonShine\Pages\fresh1c\nomenclature1cPage;
use App\MoonShine\Pages\fresh1c\users1cPage;
use App\MoonShine\Pages\fresh1c\users_1c;
use App\MoonShine\Pages\NewUserPage;
use App\MoonShine\Pages\Profit;
use Illuminate\Http\Request;
use MoonShine\Menu\MenuItem;
use MoonShine\Menu\MenuGroup;
use MoonShine\Menu\MenuDivider;
use App\MoonShine\Pages\Sys\Settings;
use App\MoonShine\Resources\BusinessTripResource;
use App\MoonShine\Resources\RouteResource;
use App\MoonShine\Resources\SalaryResource;
use App\MoonShine\Resources\RefillingResource;
use App\MoonShine\Resources\Sys\TruckResource;
use App\MoonShine\Resources\Dir\DirCargoResource;
use App\MoonShine\Resources\Dir\DirFuelTypeResource;
use App\MoonShine\Resources\Dir\DirTruckTypeResource;
use App\MoonShine\Resources\Dir\DirTruckBrandResource;
use App\MoonShine\Resources\Sys\MoonShineUserResource;
use App\MoonShine\Resources\Dir\DirFuelCategoryResource;
use App\MoonShine\Resources\Dir\DirPetrolStationResource;
use App\MoonShine\Resources\Sys\SetupIntegrationResource;
use App\MoonShine\Resources\Tariff\TariffServiceResource;
use App\MoonShine\Resources\Sys\MoonShineUserRoleResource;
use App\MoonShine\Resources\Tariff\TariffDistanceResource;
use MoonShine\Providers\MoonShineApplicationServiceProvider;
use App\MoonShine\Resources\Dir\DirPetrolStationBrandResource;
use App\MoonShine\Resources\Dir\DirRouteAddressResource;
use App\MoonShine\Resources\Dir\DirServiceResource;
use App\MoonShine\Resources\ProfitResource;
use App\MoonShine\Resources\ServiceResource;
use App\MoonShine\Resources\Tariff\TariffRouteResource;

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
            MenuGroup::make('1c', [
                MenuItem::make('users_1c', new users1cPage())->translatable('moonshine::menu'),
                MenuItem::make('nomenclature_1c', new nomenclature1cPage())->translatable('moonshine::menu'),
                MenuItem::make('contract_1c', new contract1cPage())->translatable('moonshine::menu'),
            ]),
            MenuGroup::make('users', [
                MenuItem::make('new_user', new NewUserPage())->translatable('moonshine::menu'),
                MenuItem::make(
                    static fn () => __('moonshine::system.user.users'),
                    new MoonShineUserResource()
                ),
            ])->translatable('moonshine::menu'),


            MenuItem::make('test', new DirFuelCategoryFormPage()),

            MenuItem::make('settings', new Settings())->icon('heroicons.cog-6-tooth')
                ->translatable('moonshine::setup'),


            MenuItem::make('services', new ServiceResource())
                ->translatable('moonshine::service'),
            MenuItem::make('business_trips', new BusinessTripResource())
                ->translatable('moonshine::business'),
            MenuItem::make('salaries', new SalaryResource())
                ->translatable('moonshine::salary'),
            MenuItem::make('refillings', new RefillingResource())
                ->translatable('moonshine::refilling'),
            MenuItem::make('routes', new RouteResource())
                ->translatable('moonshine::route'),
            MenuItem::make('profit', new Profit())
                ->translatable('moonshine::profit'),
            MenuItem::make('profits', new ProfitResource())
                ->translatable('moonshine::profit'),


            MenuGroup::make(static fn () => __('moonshine::ui.resource.system'), [
                MenuItem::make('trucks', new TruckResource())
                    ->translatable('moonshine::system.truck'),
                MenuItem::make(
                    static fn () => __('moonshine::system.role.roles'),
                    new MoonShineUserRoleResource()
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
                MenuItem::make('addresses', new DirRouteAddressResource())
                    ->translatable('moonshine::directory'),
                MenuItem::make('services', new DirServiceResource())
                    ->translatable('moonshine::directory'),
                MenuItem::make('cargos', new DirCargoResource())
                    ->translatable('moonshine::directory'),
                MenuDivider::make('trucks')->translatable('moonshine::directory'),

                // MenuGroup::make('trucks', [
                //     MenuItem::make('brands', new DirTruckBrandResource())
                //         ->translatable('moonshine::directory'),
                // ])->translatable('moonshine::directory'),

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

            MenuGroup::make('tariff', [
                MenuItem::make('routes', new TariffRouteResource())
                    ->translatable('moonshine::tariff'),
                MenuItem::make('services', new TariffServiceResource())
                    ->translatable('moonshine::tariff'),
                MenuItem::make('distance', new TariffDistanceResource())
                    ->translatable('moonshine::tariff'),
            ])->icon('heroicons.circle-stack')
                ->translatable('moonshine::tariff'),

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
                //'primary' => 'rgb(42, 69, 35)', // темно зеленый
                //'secondary' => 'rgb(42, 69, 35)', // темно зеленый
                //'body' => 'rgb(27, 37, 59)',
                //'body' => 'rgb(93, 160, 53)', // светло зеленый
            ],
        ];
    }
}

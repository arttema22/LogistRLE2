<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Refilling;
use MoonShine\MoonShine;
use Illuminate\Http\Request;
use MoonShine\Menu\MenuItem;
use MoonShine\Menu\MenuGroup;
use App\Models\SetupIntegration;
use App\MoonShine\Pages\E1card;
use App\MoonShine\Pages\Monopoly;
use App\MoonShine\Resources\MoonShineUserResource;
use App\MoonShine\Resources\SetupIntegrationResource;
use App\MoonShine\Resources\MoonShineUserRoleResource;
use App\MoonShine\Resources\ProfileResource;
use App\MoonShine\Resources\RefillingResource;
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
            MenuItem::make('refilling', new RefillingResource())->icon('heroicons.battery-50')
                ->translatable('moonshine::refilling'),

            MenuGroup::make(static fn () => __('moonshine::ui.resource.system'), [
                MenuItem::make(
                    static fn () => __('moonshine::ui.resource.title'),
                    new MoonShineUserResource()
                ),
                MenuItem::make(
                    static fn () => __('moonshine::ui.resource.role_title'),
                    new MoonShineUserRoleResource()
                ),
            ]),

            MenuGroup::make(static fn () => __('moonshine::integration.integrations'), [
                MenuItem::make('e1card', new E1card())->icon('heroicons.arrows-right-left')
                    ->translatable('moonshine::integration'),
                MenuItem::make('monopoly', new Monopoly())->icon('heroicons.arrows-right-left')
                    ->translatable('moonshine::integration'),
                MenuDivider::make()->canSee(function (Request $request) {
                    return $request->user('moonshine')?->id === 1;
                }),
                MenuItem::make(
                    static fn () => __('moonshine::integration.set_up'),
                    new SetupIntegrationResource()
                )->canSee(function (Request $request) {
                    return $request->user('moonshine')?->id === 1;
                })->icon('heroicons.wrench-screwdriver'),
            ])->icon('heroicons.arrows-right-left'),
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

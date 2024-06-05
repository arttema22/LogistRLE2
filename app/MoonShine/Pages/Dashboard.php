<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use App\Models\BusinessTrip;
use App\Models\Salary;
use MoonShine\Pages\Page;
use Illuminate\Support\Number;
use MoonShine\Components\When;
use MoonShine\Decorations\Grid;
use MoonShine\Decorations\Column;
use MoonShine\Metrics\ValueMetric;
use App\Models\Dir\DirFuelCategory;
use MoonShine\Decorations\Collapse;
use Illuminate\Support\Facades\Auth;
use MoonShine\Metrics\DonutChartMetric;
use App\Models\Dir\DirPetrolStationBrand;
use App\Models\Refilling;
use Illuminate\Database\Eloquent\Builder;
use MoonShine\Components\Link;
use MoonShine\Decorations\Flex;

class Dashboard extends Page
{
    public function breadcrumbs(): array
    {
        return [
            '#' => $this->title()
        ];
    }

    public function title(): string
    {
        return __('moonshine::ui.dashboard');
    }

    public function components(): array
    {
        if (Auth::user()->moonshine_user_role_id == 3) {
            // Водители
        } else {
            // Админы и менеджеры
        }

        return [
            // Водители
            When::make(
                static fn () => Auth::user()->moonshine_user_role_id == 3,
                static fn () => [
                    Grid::make([
                        // Заправки
                        Column::make([
                            Collapse::make('refillings', [

                                Flex::make([
                                    ValueMetric::make('refilling_count')
                                        ->value(Refilling::where('driver_id', Auth::user()->id)->count())
                                        ->translatable('moonshine::refilling'),
                                    ValueMetric::make('refilling_sum')
                                        ->value(Refilling::where('driver_id', Auth::user()->id)->sum('sum'))
                                        //  ->valueFormat(fn ($value) => Number::currency($value, 'RUB'))
                                        ->translatable('moonshine::refilling'),
                                ])->justifyAlign('start')->itemsAlign('start'),

                                DonutChartMetric::make('total')
                                    ->values(
                                        function () {
                                            $petrolStationBrands = DirPetrolStationBrand::withCount('refillings')
                                                ->whereHas(
                                                    'refillings',
                                                    function (Builder $query) {
                                                        $query->where('driver_id', Auth::user()->id);
                                                    }
                                                )
                                                ->get();
                                            $count = [];
                                            foreach ($petrolStationBrands as $petrolStationBrand) {
                                                $count[$petrolStationBrand->name] = $petrolStationBrand->refillings()->where('driver_id', Auth::user()->id)->count();
                                            }
                                            return $count;
                                        }
                                    )
                                    ->translatable('moonshine::directory')->columnSpan(12),

                            ])->translatable('moonshine::refilling'),
                        ])->columnSpan(6),

                        Column::make([
                            // Категории горючего
                            Collapse::make('fuel_categories', [
                                DonutChartMetric::make('total')
                                    ->values(
                                        function () {
                                            $fuelCategories = DirFuelCategory::withCount('refillings')
                                                ->whereHas(
                                                    'refillings',
                                                    function (Builder $query) {
                                                        $query->where('driver_id', Auth::user()->id);
                                                    }
                                                )
                                                ->get();
                                            $count = [];
                                            foreach ($fuelCategories as $fuelCategory) {
                                                $count[$fuelCategory->name] = $fuelCategory->refillings()->where('driver_id', Auth::user()->id)->count();
                                            }
                                            return $count;
                                        }
                                    )
                                    ->translatable('moonshine::directory'),
                            ])->translatable('moonshine::directory'),
                        ])->columnSpan(6),

                        // Выплаты
                        Column::make([
                            Collapse::make('salaries', [
                                Flex::make([
                                    ValueMetric::make('salary_count')
                                        ->value(Salary::where('driver_id', Auth::user()->id)->count())
                                        ->translatable('moonshine::salary'),
                                    ValueMetric::make('salary_sum')
                                        ->value(Salary::where('driver_id', Auth::user()->id)->sum('sum'))
                                        // ->valueFormat(fn ($value) => Number::currency($value, 'RUB'))
                                        ->translatable('moonshine::salary'),
                                ])->justifyAlign('start'),
                            ])->translatable('moonshine::salary'),
                        ])->columnSpan(6),

                        // Командировки
                        Column::make([
                            Collapse::make(
                                'business_trips',
                                [
                                    Flex::make([
                                        ValueMetric::make('business_count')
                                            ->value(BusinessTrip::where('driver_id', Auth::user()->id)->count())
                                            ->translatable('moonshine::business'),
                                        ValueMetric::make('business_sum')
                                            ->value(BusinessTrip::where('driver_id', Auth::user()->id)->sum('sum'))
                                            // ->valueFormat(fn ($value) => Number::currency($value, 'RUB'))
                                            ->translatable('moonshine::business'),
                                    ])->justifyAlign('start'),
                                ]
                            )->translatable('moonshine::business'),
                        ])->columnSpan(6),
                    ]),
                ]
            ),
            // Админы и менеджеры
            When::make(
                static fn () => Auth::user()->moonshine_user_role_id != 3,
                static fn () => [
                    Grid::make([
                        Column::make([
                            // Заправки
                            Collapse::make('refillings', [
                                DonutChartMetric::make('total')
                                    ->values(
                                        function () {
                                            $petrolStationBrands = DirPetrolStationBrand::withCount('refillings')->get();
                                            $count = [];
                                            foreach ($petrolStationBrands as $petrolStationBrand) {
                                                $count[$petrolStationBrand->name] = $petrolStationBrand->refillings_count;
                                            }
                                            return $count;
                                        }
                                    )
                                    ->translatable('moonshine::directory'),
                            ])->translatable('moonshine::refilling'),
                        ])->columnSpan(6),

                        Column::make([
                            // АЗС
                            Collapse::make('petrol_station', [
                                DonutChartMetric::make('total')
                                    ->values(
                                        function () {
                                            $petrolStationBrands = DirPetrolStationBrand::withCount('petrolStations')->get();
                                            $count = [];
                                            foreach ($petrolStationBrands as $petrolStationBrand) {
                                                $count[$petrolStationBrand->name] = $petrolStationBrand->petrol_stations_count;
                                            }
                                            return $count;
                                        }
                                    )
                                    ->translatable('moonshine::directory'),
                            ])->translatable('moonshine::directory'),
                        ])->columnSpan(6),

                        Column::make([
                            // Категории горючего
                            Collapse::make('fuel_categories', [
                                DonutChartMetric::make('total')
                                    ->values(
                                        function () {
                                            $fuelCategories = DirFuelCategory::withCount('refillings')->get();
                                            $count = [];
                                            foreach ($fuelCategories as $fuelCategory) {
                                                $count[$fuelCategory->name] = $fuelCategory->refillings_count;
                                            }
                                            return $count;
                                        }
                                    )
                                    ->translatable('moonshine::directory'),
                            ])->translatable('moonshine::directory'),
                        ])->columnSpan(6),

                        Column::make([
                            // Типы горючего
                            Collapse::make('fuel_types', [
                                DonutChartMetric::make('total')
                                    ->values(
                                        function () {
                                            $dirFuelTypes = DirFuelCategory::withCount('fuelType')->get();
                                            $count = [];
                                            foreach ($dirFuelTypes as $fuelType) {
                                                $count[$fuelType->name] = $fuelType->fuel_type_count;
                                            }
                                            return $count;
                                        }
                                    )
                                    ->translatable('moonshine::directory'),
                            ])->translatable('moonshine::directory'),
                        ])->columnSpan(6),

                        // Выплаты
                        Column::make([
                            Collapse::make('salaries', [
                                Flex::make([
                                    ValueMetric::make('salary_count')
                                        ->value(Salary::count())
                                        ->translatable('moonshine::salary'),
                                    ValueMetric::make('salary_sum')
                                        ->value(Salary::sum('sum'))
                                        //  ->valueFormat(fn ($value) => Number::currency($value, 'RUB'))
                                        ->translatable('moonshine::salary'),
                                ])->justifyAlign('start'),
                            ])->translatable('moonshine::salary'),
                        ])->columnSpan(6),

                        // Командировки
                        Column::make([
                            Collapse::make(
                                'business_trips',
                                [
                                    Flex::make([
                                        ValueMetric::make('business_count')
                                            ->value(BusinessTrip::count())
                                            ->translatable('moonshine::business'),
                                        ValueMetric::make('business_sum')
                                            ->value(BusinessTrip::sum('sum'))
                                            //    ->valueFormat(fn ($value) => Number::currency($value, 'RUB'))
                                            ->translatable('moonshine::business'),
                                    ])->justifyAlign('start'),
                                ]
                            )->translatable('moonshine::business'),
                        ])->columnSpan(6),
                    ]),
                ]
            ),
        ];
    }
}

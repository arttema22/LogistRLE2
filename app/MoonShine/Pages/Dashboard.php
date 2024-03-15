<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use App\Models\Truck;
use App\Models\Salary;
use App\Models\Refilling;
use MoonShine\Pages\Page;
use Illuminate\Http\Request;
use MoonShine\Components\When;
use MoonShine\Decorations\Grid;
use App\Models\SetupIntegration;
use MoonShine\Metrics\ValueMetric;
use Illuminate\Support\Facades\Auth;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Heading;
use MoonShine\Metrics\LineChartMetric;

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

        return [
            Grid::make([
                When::make(
                    static fn () => Auth::user()->moonshine_user_role_id === 3,
                    static fn () => [
                        LineChartMetric::make('salaries')
                            ->line(
                                [
                                    __('moonshine::salary.salaries') => Salary::query()
                                        ->selectRaw('COUNT(*) as count, DATE_FORMAT(date, "%d.%m.%Y") as date')
                                        ->where('driver_id', Auth::user()->id)
                                        ->groupByRaw('DATE_FORMAT(date, "%d.%m.%Y")')
                                        //->groupBy('date')
                                        ->pluck('count', 'date')
                                        ->toArray(),
                                    __('moonshine::refilling.refillings') => Refilling::query()
                                        ->selectRaw('COUNT(*) as count, DATE_FORMAT(date, "%d.%m.%Y") as date')
                                        ->where('driver_id', Auth::user()->id)
                                        ->groupBy('date')
                                        ->pluck('count', 'date')
                                        ->toArray(),
                                ],
                                ['rgb(42, 69, 35)', 'rgb(93, 160, 53)']
                            )
                            ->columnSpan(12)
                            ->translatable('moonshine::salary'),
                        ValueMetric::make('salaries')
                            ->value(Salary::where('driver_id', Auth::user()->id)->count())
                            ->translatable('moonshine::salary')
                            ->columnSpan(2),
                        ValueMetric::make('refillings')
                            ->value(Refilling::where('driver_id', Auth::user()->id)->count())
                            ->translatable('moonshine::refilling')
                            ->columnSpan(2),
                    ]
                ),
                When::make(
                    static fn () => Auth::user()->moonshine_user_role_id != 3,
                    static fn () => [
                        LineChartMetric::make('total')
                            ->line(
                                [
                                    __('moonshine::salary.salaries') => Salary::query()
                                        ->selectRaw('COUNT(*) as count, DATE_FORMAT(date, "%d.%m.%Y") as date')
                                        ->groupBy('date')
                                        ->pluck('count', 'date')
                                        ->toArray(),
                                    __('moonshine::refilling.refillings') => Refilling::query()
                                        ->selectRaw('COUNT(*) as count, DATE_FORMAT(date, "%d.%m.%Y") as date')
                                        ->groupBy('date')
                                        ->pluck('count', 'date')
                                        ->toArray()
                                ],
                                ['rgb(42, 69, 35)', 'rgb(93, 160, 53)']
                            )
                            ->columnSpan(12)
                            ->translatable('moonshine::ui'),
                        ValueMetric::make('salaries')
                            ->value(Salary::count())
                            ->translatable('moonshine::salary')
                            ->columnSpan(2),
                        ValueMetric::make('refillings')
                            ->value(Refilling::count())
                            ->translatable('moonshine::refilling')
                            ->columnSpan(2),
                    ]
                ),
            ]),









            // ValueMetric::make('trucks')
            //     ->value(Truck::count())
            //     ->translatable('moonshine::truck')
            //     ->columnSpan(2),

            // ValueMetric::make('monopoly')
            //     ->value(function () {
            //         $data = SetupIntegration::find(2);
            //         $balance = Monopoly::make()->callContract($data);
            //         return $balance[0]['balance'];
            //     })
            //     ->translatable('moonshine::integration')
            //     ->columnSpan(2),

            // ValueMetric::make('integrations')
            //     ->value(SetupIntegration::where('status', 1)->count())
            //     ->progress(SetupIntegration::count())
            //     ->translatable('moonshine::integration')
            //     ->canSee(function (Request $request) {
            //         return $request->user('moonshine')?->moonshine_user_role_id === 1;
            //     })
            //     ->columnSpan(2),


        ];
    }
}

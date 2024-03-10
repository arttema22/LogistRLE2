<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use App\Models\Truck;
use App\Models\Refilling;
use MoonShine\Pages\Page;
use Illuminate\Http\Request;
use MoonShine\Decorations\Grid;
use App\Models\SetupIntegration;
use MoonShine\Metrics\ValueMetric;
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
        return $this->title ?: 'Dashboard';
    }

    public function components(): array
    {

        return [
            Grid::make([

                // LineChartMetric::make('refillings')
                //     ->line([
                //         __('moonshine::refilling.num_liters_car_refueling') => Refilling::query()
                //             ->selectRaw('SUM(num_liters_car_refueling) as sum, DATE_FORMAT(date, "%d.%m.%Y") as date')
                //             ->groupBy('date')
                //             ->pluck('sum', 'date')
                //             ->toArray()
                //     ])
                // ->line([
                //     __('moonshine::refilling.num_liters_car_refueling') => Refilling::query()
                //         ->selectRaw('COUNT(num_liters_car_refueling) as count, DATE_FORMAT(date, "%d.%m.%Y") as date')
                //         ->groupBy('date')
                //         ->pluck('count', 'date')
                //         ->toArray()
                // ])

                // ->line([
                //     __('moonshine::refilling.cost_car_refueling') => Refilling::query()
                //         ->selectRaw('SUM(cost_car_refueling) as sum, DATE_FORMAT(date, "%d.%m.%Y") as date')
                //         ->groupBy('date')
                //         ->pluck('sum', 'date')
                //         ->toArray()
                // ])
                // ->line([
                //     'Avg' => Refilling::query()
                //         ->selectRaw('AVG(cost_car_refueling) as avg, DATE_FORMAT(date, "%d.%m.%Y") as date')
                //         ->groupBy('date')
                //         ->pluck('avg', 'date')
                //         ->toArray()
                // ], '#EC4176')
                // ->withoutSortKeys()
                // ->translatable('moonshine::refilling'),

                ValueMetric::make('refillings')
                    ->value(Refilling::count())
                    ->translatable('moonshine::refilling')
                    ->columnSpan(2),

                ValueMetric::make('trucks')
                    ->value(Truck::count())
                    ->translatable('moonshine::truck')
                    ->columnSpan(2),

                ValueMetric::make('monopoly')
                    ->value(function () {
                        $data = SetupIntegration::find(2);
                        $balance = Monopoly::make()->callContract($data);
                        return $balance[0]['balance'];
                    })
                    ->translatable('moonshine::integration')
                    ->columnSpan(2),

                ValueMetric::make('integrations')
                    ->value(SetupIntegration::where('status', 1)->count())
                    ->progress(SetupIntegration::count())
                    ->translatable('moonshine::integration')
                    ->canSee(function (Request $request) {
                        return $request->user('moonshine')?->moonshine_user_role_id === 1;
                    })
                    ->columnSpan(2),
            ]),

        ];
    }
}

<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use MoonShine\Pages\Page;
use Illuminate\Http\Request;
use MoonShine\Decorations\Grid;
use App\Models\SetupIntegration;
use MoonShine\Metrics\ValueMetric;

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

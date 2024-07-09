<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\fresh1c;

use MoonShine\Pages\Page;
use MoonShine\Fields\Text;
use Illuminate\Support\Facades\Http;
use MoonShine\Components\TableBuilder;
use MoonShine\Components\MoonShineComponent;

class users1cPage extends Page
{
    /**
     * @return array<string, string>
     */
    public function breadcrumbs(): array
    {
        return [
            '#' => $this->title()
        ];
    }

    public function title(): string
    {
        return __('moonshine::ui.1c.users_1c');
    }

    public function subtitle(): string
    {
        return __('moonshine::ui.1c.the_list_is_generated_in_real_time_from_1c');
    }

    /**
     * @return list<MoonShineComponent>
     */
    public function components(): array
    {
        $response = Http::withBasicAuth('odata.user', '2024_04-03_UserOdata')
            ->withHeaders([
                'Accept' => 'application/json'
            ])
            ->get(
                'https://1cfresh.com/a/sbm/2326097/odata/standard.odata/Catalog_Контрагенты',
                [
                    //'$filter' => "like(Description, '%Вийдас%')",
                    '$select' => 'Description, Ref_Key',
                    //'$select' => '**',
                    //'$format' => 'json'
                ]
            )->json();


        // dd($response['value']);

        return [
            TableBuilder::make()
                ->items($response['value'])
                ->fields([
                    Text::make('description', 'Description')->translatable('moonshine::ui.1c'),
                    Text::make('ref_key', 'Ref_Key')->translatable('moonshine::ui.1c'),
                ])
                ->withNotFound(),
        ];
    }
}

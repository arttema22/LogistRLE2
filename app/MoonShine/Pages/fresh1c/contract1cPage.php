<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\fresh1c;

use MoonShine\Pages\Page;
use MoonShine\Fields\Text;
use MoonShine\Components\Badge;
use App\Models\Sys\SetupIntegration;
use Illuminate\Support\Facades\Http;
use MoonShine\Components\TableBuilder;
use MoonShine\Components\MoonShineComponent;

class contract1cPage extends Page
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
        return __('moonshine::ui.1c.contract_1c');
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
        $data = SetupIntegration::find(3);
        $response = Http::withBasicAuth($data->user_name, $data->password)
            ->withHeaders([
                'Accept' => 'application/json'
            ])
            ->get(
                $data->url . 'Catalog_ДоговорыКонтрагентов',
                [
                    //'$filter' => "like(Description, 'Управленческий%')",
                    '$select' => 'Owner, Description, Ref_Key, Комментарий',
                    '$filter' => "like(Комментарий, '%ПТ%')",
                    //        '$select' => 'Description, Ref_Key, Комментарий',
                    //'$select' => '**',
                ]
            )->json();

        if ($response) {
            return [
                TableBuilder::make()
                    ->items($response['value'])
                    ->fields([
                        Text::make('description', 'Description')->translatable('moonshine::ui.1c'),
                        Text::make('owner', 'Owner')->translatable('moonshine::ui.1c'),
                        Text::make('ref_key', 'Ref_Key')->translatable('moonshine::ui.1c'),
                    ])
                    ->withNotFound(),
            ];
        } else {
            return [
                Badge::make(__('moonshine::ui.1c.error_connection'), 'warning'),
            ];
        }
    }
}

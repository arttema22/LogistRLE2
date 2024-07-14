<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\fresh1c;

use MoonShine\Pages\Page;
use MoonShine\Fields\Text;
use App\Models\Sys\SetupIntegration;
use Illuminate\Support\Facades\Http;
use MoonShine\Components\Badge;
use MoonShine\Components\Layout\Header;
use MoonShine\Components\TableBuilder;
use MoonShine\Components\MoonShineComponent;
use MoonShine\Decorations\Heading;

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
        $data = SetupIntegration::find(3);


        // $response = Http::withBasicAuth($data->user_name, $data->password)
        //     ->withHeaders([
        //         'Accept' => 'application/json'
        //     ])
        //     ->get(
        //         $data->url . 'Document_ПриходнаяНакладная',
        //         [
        //             //'$filter' => "like(Description, '%Хазиуллин%')",
        //             //'$filter' => "like(Комментарий, '%Водитель%')",
        //             '$orderby' => 'Date desc',
        //             '$top' => '5',
        //             //'$select' => 'Ref_Key, Комментарий',
        //         ]
        //     )->json();

        // dd($response);



        $response = Http::dd()->withBasicAuth($data->user_name, $data->password)
            ->post(
                'https://1cfresh.com/a/sbm/2326097/odata/standard.odata/Document_ПриходнаяНакладная',
                [
                    'value' => [
                        'Автор_Key' => '02b3bc60-ca5e-11ee-898a-fa163e3df684',
                        'Контрагент_Key' => '0c19ebf6-29f7-11ee-9f3e-fa163e3df684',
                        'Договор_Key' => '0bcebb4a-29f7-11ee-9f3e-fa163e3df684',
                        // 'DataVersion' => 'AAAAAAAAAAA=',
                        // 'DeletionMark' => 'false',
                        // 'Number' => 'КАНФ-002532',
                        // 'Date' => '2023-11-30T07:20:00',
                        // 'Запасы' => [
                        //     'Ref_Key' => 'f5dcbec0-9a87-11ee-9e46-fa163e3df684',
                        //     'LineNumber' => '1',
                        //     'Номенклатура_Key' => 'c4dc8fac-d0bc-11ed-8355-fa163e3df684',
                        //     'ЕдиницаИзмерения' => '0e3c0eae-bf5e-11ed-9cb3-fa163e3df684',
                        // ],
                    ],
                ]
            );

        dd($response);

        $response = Http::withBasicAuth($data->user_name, $data->password)
            ->withHeaders([
                'Accept' => 'application/json'
            ])
            ->get(
                $data->url . 'Catalog_Контрагенты',
                [
                    //'$filter' => "like(Description, '%Вийдас%')",
                    '$filter' => "like(Комментарий, '%Водитель%')",
                    '$select' => 'Description, Ref_Key, Комментарий',
                ]
            )->json();

        if ($response) {
            return [
                TableBuilder::make()
                    ->items($response['value'])
                    ->fields([
                        Text::make('description', 'Description')->translatable('moonshine::ui.1c'),
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

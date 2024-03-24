<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use MoonShine\Pages\Page;
use MoonShine\Fields\Date;
use MoonShine\Fields\Text;
use MoonShine\Fields\StackFields;
use Illuminate\Support\Collection;
use App\Models\Sys\SetupIntegration;
use Illuminate\Support\Facades\Http;
use MoonShine\Components\TableBuilder;

class E1card extends Page
{
    private int $integration_id = 1;

    public function breadcrumbs(): array
    {
        return [
            '#' => $this->title()
        ];
    }

    public function title(): string
    {
        return __('moonshine::integration.e1card');
    }

    public function components(): array
    {
        $data = SetupIntegration::find($this->integration_id);

        return [
            TableBuilder::make()
                ->fields(fn () => [])
                // ->items($this->callBalance($data))
                ->name('balance_table'),

            TableBuilder::make()
                ->fields(fn () => [
                    Date::make('date')->format('d.m.Y')->translatable('moonshine::integration'),
                    StackFields::make('truck')
                        ->fields([
                            Text::make('fuel_type', 'service_name')->translatable('moonshine::integration'),
                            Text::make('reg_number', 'auto')->translatable('moonshine::integration'),
                            Text::make('driver', 'driver')->translatable('moonshine::integration'),
                            Text::make('test', 'card'),
                        ])
                        ->translatable('moonshine::integration'),
                    Text::make('refuel_volume', 'volume')->badge('primary')->translatable('moonshine::integration'),
                    Text::make('total_costs_with_discount', 'sum')->badge('primary')->translatable('moonshine::integration'),
                    Text::make('price_per_unit', 'price')->translatable('moonshine::integration'),
                    StackFields::make('discount')
                        ->fields([
                            Text::make('discount_type', 'discount')->translatable('moonshine::integration'),
                            Text::make('discount_percent', 'discount_percentage')->translatable('moonshine::integration'),
                            Text::make('price_per_unit_with_discount', 'amount_without_discount')->translatable('moonshine::integration'),
                        ])
                        ->translatable('moonshine::integration'),
                    StackFields::make('gas_station')
                        ->fields([
                            Text::make('brand', 'brand')->translatable('moonshine::integration'),
                            Text::make('address_details', 'address')->translatable('moonshine::integration'),
                        ])
                        ->translatable('moonshine::integration'),
                ])
                ->items($this->callTransaction($data))
                ->name('transaction_table'),
        ];
    }

    // Текущий баланс
    // Метод, возвращающий информацию о балансе.
    // Метод и его входные параметры
    // HTTP-метод: GET
    // Имя метода: balance
    // Адрес метода: /agents/:clientCode/balance
    public function callBalance($data): Collection
    {
        $response = Http::accept('application/json')
            ->withHeaders([
                'access-token' => $data->access_token,
            ])
            ->get(
                $data->url . '/agents/001715406/balance',
                [
                    //'lang' => 'ru'
                    //    'from' => '2024-02-01',
                    //    'from' => '2024-02-29',
                ]
            ); //->json();

        //  dd($response);

        return collect($response['transactions']);
    }

    // Транзакции по договору (Transaction)
    // Метод, возвращающий информацию по транзакциям.
    // Метод и его входные параметры
    // HTTP-метод: POST
    // Имя метода: Transaction
    // Адрес метода: /transactions
    public function callTransaction($data): Collection
    {
        $response = Http::accept('application/json')
            ->withHeaders([
                'access-token' => $data->access_token,
            ])
            ->post(
                $data->url . '/transactions',
                [
                    'lang' => 'ru'
                ]
            )->json();

        return collect($response['transactions']);
    }
}

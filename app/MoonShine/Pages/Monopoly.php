<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use MoonShine\Pages\Page;
use MoonShine\Fields\Date;
use MoonShine\Fields\Text;
use App\Models\SetupIntegration;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use MoonShine\Components\TableBuilder;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Grid;
use MoonShine\Fields\StackFields;

class Monopoly extends Page
{
    private int $integration_id = 2;

    public function breadcrumbs(): array
    {
        return [
            '#' => $this->title()
        ];
    }

    public function title(): string
    {
        return __('moonshine::integration.monopoly');
    }

    public function components(): array
    {
        $data = SetupIntegration::find($this->integration_id);

        return [
            Grid::make([
                Column::make([
                    Block::make('contract', [
                        TableBuilder::make()
                            ->fields(fn () => [
                                StackFields::make('contract')
                                    ->fields([
                                        Text::make('number'),
                                        Date::make('date')->format('d.m.Y'),
                                    ])
                                    ->translatable('moonshine::integration'),
                                StackFields::make('details')
                                    ->fields([
                                        Text::make('inn'),
                                        Text::make('kpp'),
                                    ])
                                    ->translatable('moonshine::integration'),
                                Text::make('balance')->badge('primary')
                                    ->translatable('moonshine::integration'),
                            ])
                            ->items($this->callContract($data))
                            ->name('contract_table')
                            ->simple(),
                    ])->translatable('moonshine::integration'),
                ])->columnSpan(12),
                Column::make([
                    Block::make('payment', [
                        TableBuilder::make()
                            ->fields(fn () => [
                                Date::make('date')->format('d.m.Y')->translatable('moonshine::integration'),
                                Text::make('type', 'name')->translatable('moonshine::integration'),
                                Text::make('sum', 'total')->badge('primary')
                                    ->translatable('moonshine::integration'),
                            ])
                            ->items($this->callPayment($data))
                            ->name('payment_table'),
                    ])->translatable('moonshine::integration'),
                ])->columnSpan(12),
                Column::make([
                    Block::make('refill', [
                        TableBuilder::make()
                            ->fields(fn () => [
                                Date::make('date', 'refuelingDate')->format('d.m.Y')->translatable('moonshine::integration'),
                                StackFields::make('truck')
                                    ->fields([
                                        Text::make('fuel_type', 'fuelType')->translatable('moonshine::integration'),
                                        Text::make('reg_number', 'regNumber')->translatable('moonshine::integration'),
                                        Text::make('driver', 'driver')->translatable('moonshine::integration'),
                                        Text::make('driver_phone', 'driverPhone')->translatable('moonshine::integration'),
                                    ])
                                    ->translatable('moonshine::integration'),
                                Text::make('refuel_volume', 'refuelVolume')->badge('primary')->translatable('moonshine::integration'),
                                Text::make('total_costs_with_discount', 'totalCostsWithDiscount')->badge('primary')->translatable('moonshine::integration'),
                                Text::make('total_costs', 'totalCosts')->translatable('moonshine::integration'),
                                Text::make('price_per_unit', 'pricePerUnit')->translatable('moonshine::integration'),
                                StackFields::make('discount')
                                    ->fields([
                                        Text::make('discount_type', 'discountType')->translatable('moonshine::integration'),
                                        Text::make('discount_percent', 'discountPercent')->translatable('moonshine::integration'),
                                        Text::make('price_per_unit_with_discount', 'pricePerUnitWithDiscount')->translatable('moonshine::integration'),
                                    ])
                                    ->translatable('moonshine::integration'),
                                StackFields::make('gas_station')
                                    ->fields([
                                        Text::make('brand', 'station.brand')->translatable('moonshine::integration'),
                                        Text::make('address_details', 'station.addressDetails')->translatable('moonshine::integration'),
                                    ])
                                    ->translatable('moonshine::integration'),
                            ])
                            ->items($this->callTransaction($data))
                            ->name('transaction_table'),
                    ])->translatable('moonshine::integration'),
                ])->columnSpan(12),
            ]),
        ];
    }

    // Информация по договору (Contract)
    // Метод, возвращающий данные о договоре и его балансе.
    // Метод и его входные параметры
    // HTTP-метод: GET
    // Имя метода: Contract
    // Адрес метода: /api/v1/contracts
    public function callContract($data): Collection
    {
        return Http::withToken($data->access_token)
            ->get($data->url . '/api/v1/contracts')
            ->collect();
    }

    // Операции поступления по договору (Payment)
    // Метод и его входные параметры
    // HTTP-метод: GET
    // Имя метода: Payment
    // Адрес метода: /api/v1/contracts/{contractid}/payments?startDate={startDate}&endDate={endDate}&limit={limit}&offset={offset}
    public function callPayment($data): Collection
    {
        $response = Http::withToken($data->access_token)
            ->withUrlParameters([
                'contract_id' => $data->additionally['contract_id'],
            ])
            ->get(
                $data->url . '/api/v1/contracts/{contract_id}/payments',
                [
                    'startDate' => date('Y-m-d', strtotime(date('Y-m-d') . " - 15 day")),
                    'endDate' => date('Y-m-d'),
                    'limit' => '1000',
                ]
            )
            ->collect();

        return $response;
    }

    // Транзакции по договору (Transaction)
    // Метод, возвращающий информацию по транзакциям.
    // Метод и его входные параметры
    // HTTP-метод: GET
    // Имя метода: Transaction
    // Адрес метода: /api/v1/contracts/{contractid}/transactions?startDate={startDate}&endDate={endDate}&limit={limit}&offset={offset}
    public function callTransaction($data): Collection
    {
        $response = Http::withToken($data->access_token)
            ->withUrlParameters([
                'contract_id' => $data->additionally['contract_id'],
            ])
            ->get(
                $data->url . '/api/v1/contracts/{contract_id}/transactions',
                [
                    'startDate' => date('Y-m-d', strtotime(date('Y-m-d') . " - 1 day")),
                    'endDate' => date('Y-m-d'),
                    'limit' => '1000',
                ]
            )
            ->collect();

        return $response;
    }
}

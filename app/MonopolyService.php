<?php

namespace App;

use App\Models\Refilling;
use App\Models\Sys\SetupIntegration;
use MoonShine\Models\MoonshineUser;
use Illuminate\Support\Facades\Http;
use App\MoonShine\Controllers\IntegrationRefillingController;

class MonopolyService
{
    /**
     * callAuth
     * Аутентификация. Получение токена.
     * HTTP-метод: POST
     * Адрес метода: https://monopoly.online/Fuel.Api/api/v1/auth
     * @return void
     */
    public function callAuth()
    {
        $data = SetupIntegration::find(2);
        $response = Http::asForm()->post(
            $data->url . '/api/v1/auth',
            [
                'UserName' => $data->user_name,
                'Password' => $data->password,
            ]
        )->json();
        if (isset($response)) {
            $data->update([
                'access_token' => $response['access_token'],
            ]);
        }
    }

    /**
     * callTransaction
     * Транзакции по договору (Transaction)
     * Метод, возвращающий информацию по транзакциям.
     * HTTP-метод: GET
     * Адрес метода: https://monopoly.online/Fuel.Api/api/v1/contracts/{contract_id}/transactions
     * @return void
     */
    public function callTransaction()
    {
        $data = SetupIntegration::find(2);

        $response = Http::withToken($data->access_token)
            ->withUrlParameters([
                'contract_id' => $data->additionally['contract_id'],
            ])
            ->get(
                $data->url . '/api/v1/contracts/{contract_id}/transactions',
                [
                    'startDate' => date('Y-m-01 00:00'),
                    'endDate' => date('Y-m-d 23:59'),
                    'limit' => '1000',
                ]
            )->collect();

        if (isset($response)) {
            foreach ($response ?? [] as $transaction) {
                if (!Refilling::where('integration_id', $transaction['id'])->exists()) {

                    // Получение ID типа топлива
                    $fuelType = IntegrationRefillingController::getFuelType($transaction['fuelType']);

                    // Получение ID категории топлива
                    $fuelCategory = IntegrationRefillingController::getFuelCategory($fuelType);

                    // Получение ID бренда топливной компании
                    $petrolStationBrand = IntegrationRefillingController::getPetrolStationBrand($transaction['station']['brand']);

                    // Получение ID АЗС
                    $petrolStation = IntegrationRefillingController::getPetrolStation(
                        $transaction['station']['id'],
                        $transaction['station']['addressDetails'],
                        $petrolStationBrand,
                    );

                    // Получение ID автомобиля
                    $Truck = IntegrationRefillingController::getTruck($transaction['regNumber']);

                    // Если водитель с карточкой существует, то создается запись
                    $driver = MoonshineUser::where('phone', $transaction['driverPhone'])
                        ->where('moonshine_user_role_id', 3)->first();
                    if ($driver) {
                        Refilling::create([
                            'date' => date('Y-m-d', strtotime($transaction['refuelingDate'])),
                            'owner_id' => 1,
                            'driver_id' => $driver->id,
                            'volume' => $transaction['refuelVolume'],
                            'price' => $transaction['pricePerUnitWithDiscount'],
                            'sum' => $transaction['totalCostsWithDiscount'],
                            'dir_petrol_station_brand_id' => $petrolStationBrand,
                            'dir_petrol_station_id' => $petrolStation,
                            'dir_fuel_category_id' => $fuelCategory,
                            'dir_fuel_type_id' => $fuelType,
                            'truck_id' => $Truck,
                            'integration_id' => $transaction['id'],
                        ]);
                    };
                };
            }
            return true;
        }
        return false;
    }
}

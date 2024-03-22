<?php

namespace App;

use App\Models\Truck;
use App\Models\Refilling;
use Illuminate\Support\Str;
use App\Models\DirPetrolStation;
use App\Models\SetupIntegration;
use Spatie\Valuestore\Valuestore;
use Illuminate\Support\Collection;
use MoonShine\Models\MoonshineUser;
use Illuminate\Support\Facades\Http;
use App\Models\DirPetrolStationBrand;
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
     * callContract
     * Информация по договору
     * HTTP-метод: GET
     * Адрес метода: https://monopoly.online/Fuel.Api/api/v1/contracts
     * @return void
     */
    public function callContract()
    {
        $data = SetupIntegration::find(2);
        $response = Http::withToken(config('services.monopoly.access_token'))
            ->get($data->url . '/api/v1/contracts')
            ->collect();
        return $response;
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
                            'station_id' => $petrolStation,
                            'fuel_type_id' => $fuelType,
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

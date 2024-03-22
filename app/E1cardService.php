<?php

namespace App;

use App\Models\Refilling;
use App\Models\DirPetrolStation;
use App\Models\DirPetrolStationBrand;
use App\Models\SetupIntegration;
use App\Models\Truck;
use App\MoonShine\Controllers\IntegrationRefillingController;
use Spatie\Valuestore\Valuestore;
use MoonShine\Models\MoonshineUser;
use Illuminate\Support\Facades\Http;

class E1cardService
{
    /**
     * callTransaction
     * Транзакции по договору (Transaction)
     * Метод, возвращающий информацию по транзакциям.
     * HTTP-метод: POST
     * Адрес метода: /transactions
     * @return void
     */
    public function callTransaction()
    {
        $data = SetupIntegration::find(1);

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

        if (isset($response['transactions'])) {
            foreach ($response['transactions'] ?? [] as $transaction) {
                if (!Refilling::where('integration_id', $transaction['UnID'])->exists()) {

                    // Получение ID типа топлива
                    $fuelType = IntegrationRefillingController::getFuelType($transaction['service_name']);

                    // Получение ID бренда топливной компании
                    $petrolStationBrand = IntegrationRefillingController::getPetrolStationBrand($transaction['brand']);

                    // Получение ID АЗС
                    $petrolStation = IntegrationRefillingController::getPetrolStation(
                        $transaction['station_id'],
                        $transaction['address'],
                        $petrolStationBrand,
                    );

                    // Получение ID автомобиля
                    $Truck = IntegrationRefillingController::getTruck($transaction['auto']);

                    // Если водитель с карточкой существует, то создается запись
                    $driver = MoonshineUser::where('e1_card', $transaction['card'])
                        ->where('moonshine_user_role_id', 3)
                        ->first();
                    if ($driver) {
                        Refilling::create([
                            'date' => date('Y-m-d H:i', strtotime($transaction['date'])),
                            'owner_id' => 1,
                            'driver_id' => $driver->id,
                            'volume' => $transaction['volume'],
                            'price' => $transaction['price'],
                            'sum' => $transaction['sum'],
                            'station_id' => $petrolStation,
                            'fuel_type_id' => $fuelType,
                            'truck_id' => $Truck,
                            'integration_id' => $transaction['UnID'],
                        ]);
                    };
                };
            }
            return true;
        }
        return false;
    }
}

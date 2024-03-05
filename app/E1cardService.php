<?php

namespace App;

use App\Models\Refilling;
use App\Models\SetupIntegration;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use MoonShine\Models\MoonshineUser;

class E1cardService
{
    // Транзакции по договору (Transaction)
    // Метод, возвращающий информацию по транзакциям.
    // Метод и его входные параметры
    // HTTP-метод: POST
    // Имя метода: Transaction
    // Адрес метода: /transactions
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

                if (!Refilling::where('inegration_id', $transaction['UnID'])->exists()) {

                    $driver = MoonshineUser::where('e1_card', $transaction['card'])->first();

                    if ($driver) {
                        Refilling::create([
                            'date' => $transaction['date'],
                            'owner_id' => 1,
                            'driver_id' => $driver->id,
                            'num_liters_car_refueling' => $transaction['volume'],
                            'price_car_refueling' => env('PRICE_CAR_REFUELING', 10),
                            'cost_car_refueling' => $transaction['volume'] * env('PRICE_CAR_REFUELING', 10),
                            'station_id' => $transaction['station_id'],
                            'brand' => $transaction['brand'],
                            'address' => $transaction['address'],
                            'reg_number' => $transaction['auto'],
                            'driver_name' => $transaction['driver'],
                            'inegration_id' => $transaction['UnID'],
                        ]);
                    };
                };
            }
            return true;
        }
        return false;
    }
}

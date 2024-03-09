<?php

namespace App;

use App\Models\Refilling;
use App\Models\SetupIntegration;
use Spatie\Valuestore\Valuestore;
use Illuminate\Support\Collection;
use MoonShine\Models\MoonshineUser;
use Illuminate\Support\Facades\Http;

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
        $settings = Valuestore::make(storage_path('app/settings.json'));

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
            dd($response['transactions']);
            foreach ($response['transactions'] ?? [] as $transaction) {
                if (!Refilling::where('inegration_id', $transaction['UnID'])->exists()) {

                    $driver = MoonshineUser::where('e1_card', $transaction['card'])->first();

                    if ($driver) {
                        Refilling::create([
                            'date' => date('Y-m-d H:i:s', strtotime($transaction['date'])),
                            'owner_id' => 1,
                            'driver_id' => $driver->id,
                            'num_liters_car_refueling' => $transaction['volume'],
                            'price_car_refueling' => $settings->get('price_car_refueling'),
                            'cost_car_refueling' => $transaction['volume'] * $settings->get('price_car_refueling'),


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

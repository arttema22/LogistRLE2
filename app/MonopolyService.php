<?php

namespace App;

use App\Models\DirPetrolStation;
use App\Models\Refilling;
use App\Models\SetupIntegration;
use Spatie\Valuestore\Valuestore;
use Illuminate\Support\Collection;
use MoonShine\Models\MoonshineUser;
use Illuminate\Support\Facades\Http;

class MonopolyService
{
    // Информация по договору (Contract)
    // Метод, возвращающий данные о договоре и его балансе.
    // Метод и его входные параметры
    // HTTP-метод: GET
    // Имя метода: Contract
    // Адрес метода: /api/v1/contracts
    public function callContract()
    {
        $response = Http::withToken(config('services.monopoly.access_token'))
            ->get(config('services.monopoly.url') . '/api/v1/contracts')
            ->collect();

        return $response;

        // if (isset($response)) {
        //     foreach ($response ?? [] as $contract) {
        //         if (!FuelSupplier::where('contract_id', $contract['id'])->exists()) {
        //             FuelSupplier::create([
        //                 'name' => 'Монополия',
        //                 'contract_id' => $contract['id'],
        //                 'number' => $contract['number'],
        //                 'inn' => $contract['inn'],
        //                 'kpp' => $contract['kpp'],
        //                 'date' => $contract['date'],
        //                 'balance' => $contract['balance'],
        //             ]);
        //         } else {
        //             $Contract = FuelSupplier::where('contract_id', $contract['id'])->first();
        //             $Contract->balance = $contract['balance'];
        //             $Contract->save();
        //         };
        //     }
        // }
    }

    // Операции поступления по договору (Payment)
    // Метод и его входные параметры
    // HTTP-метод: GET
    // Имя метода: Payment
    // Адрес метода: /api/v1/contracts/{contractid}/payments?startDate={startDate}&endDate={endDate}&limit={limit}&offset={offset}
    public function callPayment()
    {
        $response = Http::withToken(config('services.monopoly.access_token'))
            ->get(
                config('services.monopoly.url') . '/api/v1/contracts/' . config('services.monopoly.contract_id') . '/payments',
                [
                    'startDate' => date('Y-m-d', strtotime(date('Y-m-d') . " - 14 day")),
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
    public function callTransaction()
    {
        $data = SetupIntegration::find(2);
        $settings = Valuestore::make(storage_path('app/settings.json'));

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
            )
            ->collect();

        if (isset($response)) {
            foreach ($response ?? [] as $transaction) {
                if (!Refilling::where('integration_id', $transaction['id'])->exists()) {

                    // Если в базе нет записи о такой АЗС, то она создается
                    $petrol_station = DirPetrolStation::where('station_id', $transaction['station']['id'])->first();
                    if (!$petrol_station) {
                        $petrol_station = DirPetrolStation::create([
                            'station_id' => $transaction['station']['id'],
                            'name' => $transaction['station']['brand'],
                            'address' => $transaction['station']['addressDetails'],
                        ]);
                    }

                    $driver = MoonshineUser::where('phone', $transaction['driverPhone'])->first();

                    if ($driver) {
                        Refilling::create([
                            'date' => date('Y-m-d H:i:s', strtotime($transaction['refuelingDate'])),
                            'owner_id' => 1,
                            'driver_id' => $driver->id,
                            'num_liters_car_refueling' => $transaction['refuelVolume'],
                            'price_car_refueling' => $settings->get('price_car_refueling'),
                            'cost_car_refueling' => $transaction['refuelVolume'] * $settings->get('price_car_refueling'),
                            'test_station_id' => $petrol_station->id,

                            'station_id' => $transaction['station']['id'],
                            'brand' => $transaction['station']['brand'],
                            'address' => $transaction['station']['addressDetails'],
                            'reg_number' => $transaction['regNumber'],
                            'driver_name' => $transaction['driver'],
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

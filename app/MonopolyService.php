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
            )->collect();

        if (isset($response)) {
            foreach ($response ?? [] as $transaction) {
                if (!Refilling::where('integration_id', $transaction['id'])->exists()) {

                    // Если в базе нет такого бренда, то он создается
                    $petrol_ststion_brand = DirPetrolStationBrand::where('name', $transaction['station']['brand'])->first();
                    if (!$petrol_ststion_brand) {
                        $petrol_ststion_brand = DirPetrolStationBrand::create([
                            'name' => $transaction['station']['brand'],
                        ]);
                    }

                    // Если в базе нет записи о такой АЗС, то она создается
                    $petrol_station = DirPetrolStation::where('station_num', $transaction['station']['id'])->first();
                    if (!$petrol_station) {
                        $petrol_station = DirPetrolStation::create([
                            'address' => $transaction['station']['addressDetails'],
                            'brand_id' => $petrol_ststion_brand->id,
                            'station_num' => $transaction['station']['id'],
                        ]);
                    }

                    // Если в базе есть запись о машине с переданным номером, то ее ID записывается
                    $truck = Truck::where('reg_num', $transaction['regNumber'])->first();
                    if ($truck) {
                        $truck_id = $truck->id;
                    } else {
                        $truck_id = null;
                    }

                    // Если водитель с карточкой существует, то создается запись
                    $driver = MoonshineUser::where('phone', $transaction['driverPhone'])->first();
                    if ($driver) {
                        Refilling::create([
                            'date' => date('Y-m-d', strtotime($transaction['refuelingDate'])),
                            'owner_id' => 1,
                            'driver_id' => $driver->id,
                            'volume' => $transaction['refuelVolume'],
                            'price' => $settings->get('price_car_refueling'),
                            'sum' => $transaction['refuelVolume'] * $settings->get('price_car_refueling'),
                            'station_id' => $petrol_station->id,
                            'truck_id' => $truck_id,
                            'reg_number' => $transaction['regNumber'],
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

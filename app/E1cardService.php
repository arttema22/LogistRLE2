<?php

namespace App;

use App\Models\Refilling;
use App\Models\DirPetrolStation;
use App\Models\DirPetrolStationBrand;
use App\Models\SetupIntegration;
use App\Models\Truck;
use Spatie\Valuestore\Valuestore;
use Illuminate\Support\Collection;
use MoonShine\Models\MoonshineUser;
use Illuminate\Support\Facades\Http;

class E1cardService
{
    /**
     * callTransaction
     * Транзакции по договору (Transaction)
     * Метод, возвращающий информацию по транзакциям.
     * Метод и его входные параметры
     * HTTP-метод: POST
     * Имя метода: Transaction
     * Адрес метода: /transactions
     *
     * @return void
     */
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
            foreach ($response['transactions'] ?? [] as $transaction) {
                if (!Refilling::where('integration_id', $transaction['UnID'])->exists()) {

                    // Если в базе нет такого бренда, то он создается
                    $petrol_ststion_brand = DirPetrolStationBrand::where('name', $transaction['brand'])->first();
                    if (!$petrol_ststion_brand) {
                        $petrol_ststion_brand = DirPetrolStationBrand::create([
                            'name' => $transaction['brand'],
                        ]);
                    }

                    // Если в базе нет записи о такой АЗС, то она создается
                    $petrol_station = DirPetrolStation::where('station_num', $transaction['station_id'])->first();
                    if (!$petrol_station) {
                        $petrol_station = DirPetrolStation::create([
                            'address' => $transaction['address'],
                            'brand_id' => $petrol_ststion_brand->id,
                            'station_num' => $transaction['station_id'],
                        ]);
                    }

                    // Если в базе есть запись о машине с переданным номером, то ее ID записывается
                    $truck = Truck::where('reg_num', $transaction['auto'])->first();
                    if ($truck) {
                        $truck_id = $truck->id;
                    } else {
                        $truck_id = null;
                    }

                    // Если водитель с карточкой существует, то создается запись
                    $driver = MoonshineUser::where('e1_card', $transaction['card'])->first();
                    if ($driver) {
                        Refilling::create([
                            'date' => $transaction['date'],
                            'owner_id' => 1,
                            'driver_id' => $driver->id,
                            'volume' => $transaction['volume'],
                            'price' => $settings->get('price_car_refueling'),
                            'sum' => $transaction['volume'] * $settings->get('price_car_refueling'),
                            'station_id' => $petrol_station->id,
                            'truck_id' => $truck_id,
                            'reg_number' => $transaction['auto'],
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

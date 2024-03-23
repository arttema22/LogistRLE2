<?php

declare(strict_types=1);

namespace App\MoonShine\Controllers;

use App\Models\Truck;
use App\Models\DirFuelType;
use MoonShine\MoonShineRequest;
use App\Models\DirPetrolStation;
use App\Models\DirPetrolStationBrand;
use Symfony\Component\HttpFoundation\Response;
use MoonShine\Http\Controllers\MoonShineController;

final class IntegrationRefillingController extends MoonShineController
{
    static function getFuelType($fuelType)
    {
        // Если в базе нет такого типа топлива, то он создается
        $Type = DirFuelType::where('name', $fuelType)->first();
        if (!$Type) {
            $Type = DirFuelType::create([
                'name' => $fuelType,
            ]);
        }
        return $Type->id;
    }

    static function getPetrolStationBrand($petrol_station_brand)
    {
        // Если в базе нет такого бренда, то он создается
        $Brand = DirPetrolStationBrand::where('name', $petrol_station_brand)->first();
        if (!$Brand) {
            $Brand = DirPetrolStationBrand::create([
                'name' => $petrol_station_brand,
            ]);
        }
        return $Brand->id;
    }

    static function getPetrolStation($petrol_station, $address, $petrol_station_brand)
    {
        // Если в базе нет записи о такой АЗС, то она создается
        $Station = DirPetrolStation::where('station_num', $petrol_station)->first();
        if (!$Station) {
            $Station = DirPetrolStation::create([
                'address' => $address,
                'brand_id' => $petrol_station_brand,
                'station_num' => $petrol_station,
            ]);
        }
        return $Station->id;
    }

    static function getTruck($num)
    {
        // Если в базе есть запись о машине с переданным номером, то ее ID записывается
        $Truck = Truck::where('reg_num_en', $num)
            ->orWhere('reg_num_ru', $num)->first();
        if ($Truck) {
            $truck_id = $Truck->id;
        } else {
            $truck_id = null;
        }
        return $truck_id;
    }
}

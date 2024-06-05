<?php

use App\Models\Sys\Truck;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trucks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('reg_num_ru')->unique();
            $table->string('reg_num_en')->unique();
            $table->BigInteger('brand_id')->unsigned();
            $table->foreign('brand_id')->references('id')->on('dir_truck_brands');
            $table->BigInteger('type_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('dir_truck_types');
            $table->BigInteger('driver_id')->unsigned();
            $table->foreign('driver_id')->references('id')->on('moonshine_users');
            $table->softDeletes();
        });

        Truck::create([
            'name' => 'Actros',
            'reg_num_ru' => 'С 294 ХК 198',
            'reg_num_en' => 'C294XK198',
            'brand_id' => 1,
            'type_id' => 1,
            'driver_id' => 16,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num_ru' => 'Р 097 ОТ 198',
            'reg_num_en' => 'P097OT198',
            'brand_id' => 1,
            'type_id' => 1,
            'driver_id' => 10,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num_ru' => 'В 185 АХ 198',
            'reg_num_en' => 'B185AX198',
            'brand_id' => 1,
            'type_id' => 3,
            'driver_id' => 4,
        ]);

        Truck::create([
            'name' => 'G440',
            'reg_num_ru' => 'О 547 НТ 198',
            'reg_num_en' => 'O547HT198',
            'brand_id' => 3,
            'type_id' => 2,
            'driver_id' => 7,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num_ru' => 'Е 931 ТН 198',
            'reg_num_en' => 'E931TH198',
            'brand_id' => 1,
            'type_id' => 1,
            'driver_id' => 9,
        ]);

        Truck::create([
            'name' => 'G440',
            'reg_num_ru' => 'В 101 КВ 198',
            'reg_num_en' => 'B101KB198',
            'brand_id' => 3,
            'type_id' => 4,
            'driver_id' => 5,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num_ru' => 'У 548 ОВ 178',
            'reg_num_en' => 'Y548OB178',
            'brand_id' => 1,
            'type_id' => 3,
            'driver_id' => 8,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num_ru' => 'О 579 РН 198',
            'reg_num_en' => 'O579PH198',
            'brand_id' => 1,
            'type_id' => 4,
            'driver_id' => 17,
        ]);

        Truck::create([
            'name' => 'FH16',
            'reg_num_ru' => 'У 396 КТ 47',
            'reg_num_en' => 'Y396KT47',
            'brand_id' => 2,
            'type_id' => 4,
            'driver_id' => 6,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num_ru' => 'Р 792 НХ 198',
            'reg_num_en' => 'P792HX198',
            'brand_id' => 1,
            'type_id' => 2,
            'driver_id' => 11,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num_ru' => 'Х 060 МН 178',
            'reg_num_en' => 'X060MH178',
            'brand_id' => 1,
            'type_id' => 2,
            'driver_id' => 3,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num_ru' => 'В 142 СТ 198',
            'reg_num_en' => 'B142CT198',
            'brand_id' => 1,
            'type_id' => 1,
            'driver_id' => 12,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num_ru' => 'А 513 ТН 198',
            'reg_num_en' => 'A513TH198',
            'brand_id' => 1,
            'type_id' => 1,
            'driver_id' => 19,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num_ru' => 'В 280 ХВ 178',
            'reg_num_en' => 'B280XB178',
            'brand_id' => 1,
            'type_id' => 3,
            'driver_id' => 18,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trucks');
    }
};

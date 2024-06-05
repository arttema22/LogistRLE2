<?php

use App\Models\Tariff\TariffDistance;
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
        Schema::create('tariff_distances', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->BigInteger('truck_type_id')->unsigned();
            $table->foreign('truck_type_id')->references('id')->on('dir_truck_types')->onDelete('cascade');
            $table->float('0_15', 8, 2)->default(0);
            $table->float('16_30', 8, 2)->default(0);
            $table->float('31_60', 8, 2)->default(0);
            $table->float('60_300', 8, 2)->default(0);
            $table->float('300_00', 8, 2)->default(0);
        });

        TariffDistance::create([
            'truck_type_id' => 1,
            '0_15' => 5000,
            '16_30' => 8000,
            '31_60' => 8000,
            '60_300' => 115,
            '300_00' => 115,
        ]);
        TariffDistance::create([
            'truck_type_id' => 2,
            '0_15' => 5000,
            '16_30' => 8000,
            '31_60' => 8000,
            '60_300' => 115,
            '300_00' => 115,
        ]);
        TariffDistance::create([
            'truck_type_id' => 3,
            '0_15' => 5000,
            '16_30' => 8000,
            '31_60' => 8000,
            '60_300' => 120,
            '300_00' => 120,
        ]);
        TariffDistance::create([
            'truck_type_id' => 4,
            '0_15' => 6000,
            '16_30' => 8000,
            '31_60' => 10000,
            '60_300' => 120,
            '300_00' => 100,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tariff_distances');
    }
};

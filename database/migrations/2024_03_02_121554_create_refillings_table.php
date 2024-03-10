<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('refillings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->dateTime('date');
            $table->BigInteger('owner_id')->unsigned();
            $table->foreign('owner_id')->references('id')->on('moonshine_users');
            $table->BigInteger('driver_id')->unsigned();
            $table->foreign('driver_id')->references('id')->on('moonshine_users');
            // $table->BigInteger('petrol_stations_id')->unsigned();
            // $table->foreign('petrol_stations_id')->references('id')->on('dir_petrol_stations');
            $table->float('num_liters_car_refueling', 8, 2);
            $table->float('price_car_refueling', 8, 2)->nullable();
            $table->float('cost_car_refueling', 8, 2)->nullable();

            $table->string('station_id')->nullable();
            $table->string('brand')->nullable();
            $table->string('address')->nullable();
            $table->string('reg_number')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('integration_id')->nullable();
            $table->BigInteger('profit_id')->unsigned()->default(0);

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refillings');
    }
};

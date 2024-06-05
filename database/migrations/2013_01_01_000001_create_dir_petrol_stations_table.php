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
        Schema::create('dir_petrol_stations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('address');
            $table->BigInteger('dir_petrol_station_brand_id')->unsigned()->nullable();
            $table->foreign('dir_petrol_station_brand_id')->references('id')->on('dir_petrol_station_brands');
            $table->string('station_num')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dir_petrol_stations');
    }
};

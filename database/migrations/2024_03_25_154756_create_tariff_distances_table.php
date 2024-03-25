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
        Schema::create('tariff_distances', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->BigInteger('truck_type_id')->unsigned();
            $table->foreign('truck_type_id')->references('id')->on('dir_truck_types');
            $table->float('0_15', 8, 2)->default(0);
            $table->float('16_30', 8, 2)->default(0);
            $table->float('31_60', 8, 2)->default(0);
            $table->float('60_300', 8, 2)->default(0);
            $table->float('300_00', 8, 2)->default(0);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tariff_distances');
    }
};

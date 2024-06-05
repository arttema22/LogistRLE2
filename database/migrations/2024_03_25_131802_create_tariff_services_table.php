<?php

use App\Models\Tariff\TariffService;
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
        Schema::create('tariff_services', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->BigInteger('service_id')->unsigned();
            $table->foreign('service_id')->references('id')->on('dir_services')->onDelete('cascade');
            $table->float('price', 8, 2);
        });

        TariffService::create([
            'service_id' => 1,
            'price' => 500.00,
        ]);
        TariffService::create([
            'service_id' => 2,
            'price' => 500.00,
        ]);
        TariffService::create([
            'service_id' => 3,
            'price' => 500.00,
        ]);
        TariffService::create([
            'service_id' => 4,
            'price' => 500.00,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tariff_services');
    }
};

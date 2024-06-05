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
        Schema::create('tariff_routes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->BigInteger('start_id')->unsigned();
            $table->foreign('start_id')->references('id')->on('dir_route_addresses');
            $table->BigInteger('finish_id')->unsigned();
            $table->foreign('finish_id')->references('id')->on('dir_route_addresses');
            $table->Integer('length')->nullable();
            $table->float('price', 8, 2)->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tariff_routes');
    }
};

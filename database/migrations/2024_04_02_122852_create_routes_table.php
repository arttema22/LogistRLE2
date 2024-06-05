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
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('date');
            $table->BigInteger('owner_id')->unsigned();
            $table->foreign('owner_id')->references('id')->on('moonshine_users');
            $table->BigInteger('driver_id')->unsigned();
            $table->foreign('driver_id')->references('id')->on('moonshine_users');

            //$table->BigInteger('dir_type_trucks_id')->unsigned();
            //$table->foreign('dir_type_trucks_id')->references('id')->on('dir_type_trucks');
            $table->BigInteger('cargo_id')->unsigned();
            $table->foreign('cargo_id')->references('id')->on('dir_cargos');
            //$table->BigInteger('payer_id')->unsigned();
            //$table->foreign('payer_id')->references('id')->on('dir_payers');

            $table->string('address_loading');
            $table->string('address_unloading');

            //$table->Integer('route_length')->default(0);
            //$table->float('price_route', 8, 2);
            $table->Integer('number_trips');
            $table->float('unexpected_expenses', 8, 2)->nullable()->default(0);
            //$table->float('summ_route', 8, 2);

            $table->text('comment')->nullable();
            $table->BigInteger('profit_id')->unsigned()->default(0);

            //$table->boolean('status')->default(1);

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};

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
        Schema::create('trucks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('reg_num')->unique();
            $table->BigInteger('brand_id')->unsigned();
            $table->foreign('brand_id')->references('id')->on('dir_truck_brands');
            $table->BigInteger('type_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('dir_truck_types');
            $table->softDeletes();
        });

        Schema::create('truck_user', function (Blueprint $table) {
            $table->BigInteger('truck_id')->unsigned();
            $table->BigInteger('user_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('truck_user');

        Schema::dropIfExists('trucks');
    }
};

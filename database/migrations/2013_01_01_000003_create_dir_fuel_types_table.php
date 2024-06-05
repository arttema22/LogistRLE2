<?php

use App\Models\Dir\DirFuelType;
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
        Schema::create('dir_fuel_types', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name')->unique();
            $table->BigInteger('dir_fuel_category_id')->unsigned()->default(1);
            $table->foreign('dir_fuel_category_id')->references('id')->on('dir_fuel_categories');
            $table->softDeletes();
        });

        DirFuelType::create([
            'name' => 'ДТ лето',
            'dir_fuel_category_id' => 2,
        ]);
        DirFuelType::create([
            'name' => 'ДТ зима',
            'dir_fuel_category_id' => 2,
        ]);
        DirFuelType::create([
            'name' => 'ДТ',
            'dir_fuel_category_id' => 2,
        ]);
        DirFuelType::create([
            'name' => 'Бензин АИ95',
            'dir_fuel_category_id' => 3,
        ]);
        DirFuelType::create([
            'name' => 'Бензин АИ92',
            'dir_fuel_category_id' => 3,
        ]);
        DirFuelType::create([
            'name' => 'ДТ евро',
            'dir_fuel_category_id' => 2,
        ]);
        DirFuelType::create([
            'name' => 'АИ-95',
            'dir_fuel_category_id' => 3,
        ]);
        DirFuelType::create([
            'name' => 'ДТ Опти',
            'dir_fuel_category_id' => 2,
        ]);
        DirFuelType::create([
            'name' => 'АИ-95-Фирм',
            'dir_fuel_category_id' => 3,
        ]);
        DirFuelType::create([
            'name' => 'АИ-92',
            'dir_fuel_category_id' => 3,
        ]);
        DirFuelType::create([
            'name' => 'ДТ зимнее',
            'dir_fuel_category_id' => 2,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dir_fuel_types');
    }
};

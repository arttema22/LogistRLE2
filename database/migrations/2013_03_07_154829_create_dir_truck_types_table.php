<?php

use App\Models\Dir\DirTruckType;
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
        Schema::create('dir_truck_types', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name')->unique();
        });

        DirTruckType::create([
            'name' => 'Щеповоз'
        ]);
        DirTruckType::create([
            'name' => 'Тент'
        ]);
        DirTruckType::create([
            'name' => 'Лесовоз'
        ]);
        DirTruckType::create([
            'name' => 'Лесовоз-фишка'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dir_truck_types');
    }
};

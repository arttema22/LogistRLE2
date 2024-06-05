<?php

use App\Models\Dir\DirTruckBrand;
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
        Schema::create('dir_truck_brands', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name')->unique();
            $table->softDeletes();
        });

        DirTruckBrand::create([
            'name' => 'Mercedes-Benz'
        ]);
        DirTruckBrand::create([
            'name' => 'Volvo'
        ]);
        DirTruckBrand::create([
            'name' => 'Scania'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dir_truck_brands');
    }
};

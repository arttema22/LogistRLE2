<?php

use App\Models\Dir\DirService;
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
        Schema::create('dir_services', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name')->unique();
            $table->string('1с_ref_key')->unique()->nullable();
        });

        DirService::create([
            'name' => 'Погрузка',
        ]);
        DirService::create([
            'name' => 'Разгрузка',
        ]);
        DirService::create([
            'name' => 'Раскомлевка',
        ]);
        DirService::create([
            'name' => 'Сортировка',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dir_services');
    }
};

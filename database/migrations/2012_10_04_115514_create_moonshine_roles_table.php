<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use MoonShine\Models\MoonshineUserRole;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('moonshine_user_roles', static function (Blueprint $table): void {
            $table->id();
            $table->timestamps();
            $table->string('name');
        });

        MoonshineUserRole::create([
            'name' => 'Admin',
        ]);

        MoonshineUserRole::create([
            'name' => 'Администратор'
        ]);

        MoonshineUserRole::create([
            'name' => 'Водитель'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moonshine_user_roles');
    }
};

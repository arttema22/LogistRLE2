<?php

use App\Models\Dir\DirCargo;
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
        Schema::create('dir_cargos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name')->unique();
            $table->softDeletes();
        });

        DirCargo::create([
            'name' => 'Доска',
        ]);
        DirCargo::create([
            'name' => 'Брус',
        ]);
        DirCargo::create([
            'name' => 'Поддоны',
        ]);
        DirCargo::create([
            'name' => 'Щепа топливная',
        ]);
        DirCargo::create([
            'name' => 'Щепа арболит',
        ]);
        DirCargo::create([
            'name' => 'Опилки',
        ]);
        DirCargo::create([
            'name' => 'Биомасса',
        ]);
        DirCargo::create([
            'name' => 'Баланс береза',
        ]);
        DirCargo::create([
            'name' => 'Баланс сосна',
        ]);
        DirCargo::create([
            'name' => 'Пиловочник',
        ]);
        DirCargo::create([
            'name' => 'Тонкомер',
        ]);
        DirCargo::create([
            'name' => 'Горбыль',
        ]);
        DirCargo::create([
            'name' => 'Дрова',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dir_cargos');
    }
};

<?php

use App\Models\Sys\UserProfil;
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
        Schema::create('user_profils', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('driver_id')
                ->constrained('moonshine_users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('surname');
            $table->string('name');
            $table->string('patronymic')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('e1_card')->unique()->nullable();
        });

        UserProfil::create([
            'driver_id' => 1,
            'surname' => 'system',
            'name' => 'system',
        ]);

        UserProfil::create([
            'driver_id' => 2,
            'surname' => 'Гусев',
            'name' => 'Артем',
            'patronymic' => 'Александрович',
            'phone' => '79119268188',
        ]);

        UserProfil::create([
            'driver_id' => 3,
            'surname' => 'Хазиуллин',
            'name' => 'Андрей',
            'patronymic' => 'Рафисович',
            'phone' => '79214432509',
            'e1_card' => '7005230017154060139',
        ]);

        UserProfil::create([
            'driver_id' => 4,
            'surname' => 'Молчанов',
            'name' => 'Александр',
            'patronymic' => 'Антонович',
            'phone' => '79312629190',
            'e1_card' => '7005230017154060022',
        ]);

        UserProfil::create([
            'driver_id' => 5,
            'surname' => 'Лукин',
            'name' => 'Вячеслав',
            'patronymic' => 'Владимирович',
            'phone' => '79657711838',
            'e1_card' => '7005230017154060014',
        ]);

        UserProfil::create([
            'driver_id' => 6,
            'surname' => 'Мещеряков',
            'name' => 'Алексей',
            'patronymic' => 'Николаевич',
            'phone' => '79218600782',
            'e1_card' => '7005230017154060030',
        ]);

        UserProfil::create([
            'driver_id' => 7,
            'surname' => 'Екимов',
            'name' => 'Алексей',
            'patronymic' => 'Сергеевич',
            'phone' => '79219754573',
            'e1_card' => '7005230017154060121',
        ]);

        UserProfil::create([
            'driver_id' => 8,
            'surname' => 'Майоров',
            'name' => 'Иван',
            'patronymic' => 'Яковлевич',
            'phone' => '79216540978',
            'e1_card' => '7005230017154060105',
        ]);

        UserProfil::create([
            'driver_id' => 9,
            'surname' => 'Леонтьев',
            'name' => 'Александр',
            'patronymic' => 'Анатольевич',
            'phone' => '79214270568',
            'e1_card' => '7005230017154060147',
        ]);

        UserProfil::create([
            'driver_id' => 10,
            'surname' => 'Владимиров',
            'name' => 'Алексей',
            'patronymic' => 'Сергеевич',
            'phone' => '79312148432',
            'e1_card' => '7005230017154060063',
        ]);

        UserProfil::create([
            'driver_id' => 11,
            'surname' => 'Тилик',
            'name' => 'Денис',
            'patronymic' => 'Дмитриевич',
            'phone' => '79313219697',
            'e1_card' => '7005230017154060055',
        ]);

        UserProfil::create([
            'driver_id' => 12,
            'surname' => 'Думцев',
            'name' => 'Игорь',
            'patronymic' => 'Александрович',
            'phone' => '79210014828',
            'e1_card' => '7005230017154060071',
        ]);

        UserProfil::create([
            'driver_id' => 13,
            'surname' => 'Клишевич',
            'name' => 'Андрей',
            'patronymic' => 'Владимирович',
            'phone' => '79219132900',
        ]);

        UserProfil::create([
            'driver_id' => 14,
            'surname' => 'Никандров',
            'name' => 'Алексей',
            'patronymic' => 'Анатольевич',
            'phone' => '79218864280',
        ]);

        UserProfil::create([
            'driver_id' => 15,
            'surname' => 'Мамина',
            'name' => 'Лаура',
            'patronymic' => 'Игоревна',
            'phone' => '79117719191',
        ]);

        UserProfil::create([
            'driver_id' => 16,
            'surname' => 'Быков',
            'name' => 'Иван',
            'patronymic' => 'Николаевич',
            'phone' => '79212466953',
            'e1_card' => '7005230017154060097',
        ]);

        UserProfil::create([
            'driver_id' => 17,
            'surname' => 'Максимов',
            'name' => 'Иван',
            'patronymic' => 'Владимирович',
            'phone' => '79214423011',
            'e1_card' => '7005230017154060048',
        ]);

        UserProfil::create([
            'driver_id' => 18,
            'surname' => 'Молчанов',
            'name' => 'Антон',
            'patronymic' => 'Александрович',
            'phone' => '79211898330',
            'e1_card' => '7005230017154060113',
        ]);

        UserProfil::create([
            'driver_id' => 19,
            'surname' => 'Вийдас',
            'name' => 'Виктор',
            'patronymic' => 'Юрьевич',
            'phone' => '79117210092',
            'e1_card' => '7005230017154060089',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profils');
    }
};

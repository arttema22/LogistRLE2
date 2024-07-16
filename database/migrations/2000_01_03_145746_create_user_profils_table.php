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
            $table->string('1c_ref_key')->unique()->nullable();
            $table->string('1c_contract')->unique()->nullable();
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
            '1c_ref_key' => '0c19ebf6-29f7-11ee-9f3e-fa163e3df684',
            '1c_contract' => '0bcebb4a-29f7-11ee-9f3e-fa163e3df684',
        ]);

        UserProfil::create([
            'driver_id' => 4,
            'surname' => 'Молчанов',
            'name' => 'Александр',
            'patronymic' => 'Антонович',
            'phone' => '79312629190',
            'e1_card' => '7005230017154060022',
            '1c_ref_key' => 'b69cd44e-29f7-11ee-9f3e-fa163e3df684',
            '1c_contract' => 'b69c8d72-29f7-11ee-9f3e-fa163e3df684',
        ]);

        UserProfil::create([
            'driver_id' => 5,
            'surname' => 'Лукин',
            'name' => 'Вячеслав',
            'patronymic' => 'Владимирович',
            'phone' => '79657711838',
            'e1_card' => '7005230017154060014',
            '1c_ref_key' => 'e321907c-29f7-11ee-9f3e-fa163e3df684',
            '1c_contract' => 'e3214c34-29f7-11ee-9f3e-fa163e3df684',
        ]);

        UserProfil::create([
            'driver_id' => 6,
            'surname' => 'Мещеряков',
            'name' => 'Алексей',
            'patronymic' => 'Николаевич',
            'phone' => '79218600782',
            'e1_card' => '7005230017154060030',
            '1c_ref_key' => '045a5472-29f8-11ee-9f3e-fa163e3df684',
            '1c_contract' => '0459dc04-29f8-11ee-9f3e-fa163e3df684',
        ]);

        UserProfil::create([
            'driver_id' => 7,
            'surname' => 'Екимов',
            'name' => 'Алексей',
            'patronymic' => 'Сергеевич',
            'phone' => '79219754573',
            'e1_card' => '7005230017154060121',
            '1c_ref_key' => '3bf40266-29f8-11ee-9f3e-fa163e3df684',
            '1c_contract' => '3bf3af00-29f8-11ee-9f3e-fa163e3df684',
        ]);

        UserProfil::create([
            'driver_id' => 8,
            'surname' => 'Майоров',
            'name' => 'Иван',
            'patronymic' => 'Яковлевич',
            'phone' => '79216540978',
            'e1_card' => '7005230017154060105',
            '1c_ref_key' => 'a070cb7a-29f8-11ee-9f3e-fa163e3df684',
            '1c_contract' => 'a0707fd0-29f8-11ee-9f3e-fa163e3df684',
        ]);

        UserProfil::create([
            'driver_id' => 9,
            'surname' => 'Леонтьев',
            'name' => 'Александр',
            'patronymic' => 'Анатольевич',
            'phone' => '79214270568',
            'e1_card' => '7005230017154060147',
            '1c_ref_key' => '929565f6-2610-11ee-9f3e-fa163e3df684',
            '1c_contract' => '9294fc24-2610-11ee-9f3e-fa163e3df684',
        ]);

        UserProfil::create([
            'driver_id' => 10,
            'surname' => 'Владимиров',
            'name' => 'Алексей',
            'patronymic' => 'Сергеевич',
            'phone' => '79312148432',
            'e1_card' => '7005230017154060063',
            '1c_ref_key' => 'b279f39a-29f9-11ee-9f3e-fa163e3df684',
            '1c_contract' => 'b279b038-29f9-11ee-9f3e-fa163e3df684',
        ]);

        UserProfil::create([
            'driver_id' => 11,
            'surname' => 'Тилик',
            'name' => 'Денис',
            'patronymic' => 'Дмитриевич',
            'phone' => '79313219697',
            'e1_card' => '7005230017154060055',
            '1c_ref_key' => 'cf578e78-29f9-11ee-9f3e-fa163e3df684',
            '1c_contract' => 'cf574c60-29f9-11ee-9f3e-fa163e3df684',
        ]);

        UserProfil::create([
            'driver_id' => 12,
            'surname' => 'Думцев',
            'name' => 'Игорь',
            'patronymic' => 'Александрович',
            'phone' => '79210014828',
            'e1_card' => '7005230017154060071',
            '1c_ref_key' => '20193a46-29fa-11ee-9f3e-fa163e3df684',
            '1c_contract' => '2018f702-29fa-11ee-9f3e-fa163e3df684',
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
            '1c_ref_key' => '3edfaa28-29fa-11ee-9f3e-fa163e3df684',
            '1c_contract' => '3edf65b8-29fa-11ee-9f3e-fa163e3df684',
        ]);

        UserProfil::create([
            'driver_id' => 17,
            'surname' => 'Максимов',
            'name' => 'Иван',
            'patronymic' => 'Владимирович',
            'phone' => '79214423011',
            'e1_card' => '7005230017154060048',
            '1c_ref_key' => '5c91cd6c-29fa-11ee-9f3e-fa163e3df684',
            '1c_contract' => '5c918dde-29fa-11ee-9f3e-fa163e3df684',
        ]);

        UserProfil::create([
            'driver_id' => 18,
            'surname' => 'Молчанов',
            'name' => 'Антон',
            'patronymic' => 'Александрович',
            'phone' => '79211898330',
            'e1_card' => '7005230017154060113',
            '1c_ref_key' => '6c6f1adc-667c-11ee-90ec-fa163e3df684',
            '1c_contract' => '6c7136a0-667c-11ee-90ec-fa163e3df684',
        ]);

        UserProfil::create([
            'driver_id' => 19,
            'surname' => 'Вийдас',
            'name' => 'Виктор',
            'patronymic' => 'Юрьевич',
            'phone' => '79117210092',
            'e1_card' => '7005230017154060089',
            '1c_ref_key' => '8a70d204-d6d5-11ee-9c16-fa163e3df684',
            '1c_contract' => '8a72e3b4-d6d5-11ee-9c16-fa163e3df684',
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

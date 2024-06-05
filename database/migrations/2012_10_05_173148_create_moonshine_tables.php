<?php

use App\Models\Sys\MoonshineUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use MoonShine\Models\MoonshineUserRole;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('moonshine_users', static function (Blueprint $table): void {
            $table->id();
            $table->timestamps();
            $table->foreignId('moonshine_user_role_id')
                ->default(MoonshineUserRole::DEFAULT_ROLE_ID)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('email', 190)->unique();
            // $table->string('phone')->unique();
            $table->string('password');
            $table->string('name');
            //  $table->string('e1_card')->unique()->nullable();
            $table->string('avatar')->nullable();
            $table->string('remember_token', 100)->nullable();
        });

        MoonshineUser::create([
            'moonshine_user_role_id' => 1,
            'email' => '9268188@mail.ru ',
            //'phone' => '9268188',
            'password' => Hash::make('1234qwerQWER'),
            'name' => 'system',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 1,
            'email' => 'arttema@mail.ru',
            //'phone' => '79119268188',
            'password' => Hash::make('1234qwerQWER'),
            //'name' => 'Гусев Артем Александрович',
            'name' => 'Гусев А.А.',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'haziullin.andrei@mail.ru',
            //'phone' => '79214432509',
            'password' => Hash::make('radswad0'),
            //'name' => 'Хазиуллин Андрей Рафисович',
            'name' => 'Хазиуллин А.Р.',
            //'e1_card' => '7005230017154060139',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'sachamol75@gmail.com',
            //'phone' => '79312629190',
            'password' => Hash::make('radswad0'),
            //'name' => 'Молчанов Александр Антонович',
            'name' => 'Молчанов А.А.',
            //'e1_card' => '7005230017154060022',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'lukin_vyacheslav@mail.ru',
            //'phone' => '79657711838',
            'password' => Hash::make('radswad0'),
            //'name' => 'Лукин Вячеслав Владимирович',
            'name' => 'Лукин В.В.',
            //'e1_card' => '7005230017154060014',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'aleksii.99@mail.ru',
            //'phone' => '79218600782',
            'password' => Hash::make('radswad0'),
            //'name' => 'Мещеряков Алексей Николаевич',
            'name' => 'Мещеряков А.Н.',
            //'e1_card' => '7005230017154060030',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'alex-1884@mail.ru',
            //'phone' => '79219754573',
            'password' => Hash::make('radswad0'),
            //'name' => 'Екимов Алексей Сергеевич',
            'name' => 'Екимов А.С.',
            //'e1_card' => '7005230017154060121',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'maiorov.ivan1986@mail.ru',
            //'phone' => '79216540978',
            'password' => Hash::make('radswad0'),
            //'name' => 'Майоров Иван Яковлевич',
            'name' => 'Майоров И.Я.',
            //'e1_card' => '7005230017154060105',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'mers862@mail.ru',
            //'phone' => '79214270568',
            'password' => Hash::make('radswad0'),
            //'name' => 'Леонтьев Александр Анатольевич',
            'name' => 'Леонтьев А.А.',
            //'e1_card' => '7005230017154060147',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'vladimirov@inbox.ru',
            //'phone' => '79312148432',
            'password' => Hash::make('radswad0'),
            //'name' => 'Владимиров Алексей Сергеевич',
            'name' => 'Владимиров А.С.',
            //'e1_card' => '7005230017154060063',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'denis.tilik@yandex.ru',
            //'phone' => '79313219697',
            'password' => Hash::make('radswad0'),
            //'name' => 'Тилик Денис Дмитриевич',
            'name' => 'Тилик Д.Д.',
            //'e1_card' => '7005230017154060055',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'dumtsev.igor@bk.ru',
            //'phone' => '79210014828',
            'password' => Hash::make('radswad0'),
            //'name' => 'Думцев Игорь Александрович',
            'name' => 'Думцев И.А.',
            //'e1_card' => '7005230017154060071',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 2,
            'email' => '9132900@gmail.com',
            //'phone' => '79219132900',
            'password' => Hash::make('radswad0'),
            //'name' => 'Клишевич Андрей Владимирович',
            'name' => 'Клишевич А.В.',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 2,
            'email' => 'naa@rlexport.ru',
            //'phone' => '79218864280',
            'password' => Hash::make('P1$t0let'),
            //'name' => 'Никандров Алексей Анатольевич',
            'name' => 'Никандров А.А.',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 2,
            'email' => 'mli@rlexport.ru',
            //'phone' => '79117719191',
            'password' => Hash::make('xu7Heme'),
            //'name' => 'Мамина Лаура Игоревна',
            'name' => 'Мамина Л.И.',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'bykov@rlexport.ru',
            //'phone' => '79212466953',
            'password' => Hash::make('radswad0'),
            //'name' => 'Быков Иван Николаевич',
            'name' => 'Быков И.Н.',
            //'e1_card' => '7005230017154060097',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'maksimovivanmaz459@gmail.com',
            //'phone' => '79214423011',
            'password' => Hash::make('radswad0'),
            //'name' => 'Максимов Иван Владимирович',
            'name' => 'Максимов И.В.',
            //'e1_card' => '7005230017154060048',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'enter22866@gmail.com',
            //'phone' => '79211898330',
            'password' => Hash::make('radswad0'),
            //'name' => 'Молчанов Антон Александрович',
            'name' => 'Молчанов А.А.',
            //'e1_card' => '7005230017154060113',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'viidas.viktor@yandex.ru',
            //'phone' => '79117210092',
            'password' => Hash::make('radswad0'),
            //'name' => 'Вийдас Виктор Юрьевич',
            'name' => 'Вийдас В.Ю.',
            //'e1_card' => '7005230017154060089',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moonshine_users');
    }
};

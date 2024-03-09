<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use MoonShine\Models\MoonshineUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class MoonshineUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MoonshineUser::create([
            'moonshine_user_role_id' => 1,
            'email' => '9268188@mail.ru ',
            'phone' => '9268188',
            'password' => Hash::make('1234qwerQWER'),
            'name' => 'system',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 1,
            'email' => 'arttema@mail.ru',
            'phone' => '79119268188',
            'password' => Hash::make('1234qwerQWER'),
            'name' => 'Гусев Артем Александрович',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'haziullin.andrei@mail.ru',
            'phone' => '79214432509',
            'password' => Hash::make('radswad0'),
            'name' => 'Хазиуллин Андрей Рафисович',
            'e1_card' => '7005230017154060139',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'sachamol75@gmail.com',
            'phone' => '79312629190',
            'password' => Hash::make('radswad0'),
            'name' => 'Молчанов Александр Антонович',
            'e1_card' => '7005230017154060022',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'lukin_vyacheslav@mail.ru',
            'phone' => '79657711838',
            'password' => Hash::make('radswad0'),
            'name' => 'Лукин Вячеслав Владимирович',
            'e1_card' => '7005230017154060014',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'aleksii.99@mail.ru',
            'phone' => '79218600782',
            'password' => Hash::make('radswad0'),
            'name' => 'Мещеряков Алексей Николаевич',
            'e1_card' => '7005230017154060030',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'alex-1884@mail.ru',
            'phone' => '79219754573',
            'password' => Hash::make('radswad0'),
            'name' => 'Екимов Алексей Сергеевич',
            'e1_card' => '7005230017154060121',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'maiorov.ivan1986@mail.ru',
            'phone' => '79216540978',
            'password' => Hash::make('radswad0'),
            'name' => 'Майоров Иван Яковлевич',
            'e1_card' => '7005230017154060105',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'mers862@mail.ru',
            'phone' => '79214270568',
            'password' => Hash::make('radswad0'),
            'name' => 'Леонтьев Александр Анатольевич',
            'e1_card' => '7005230017154060147',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'vladimirov@inbox.ru',
            'phone' => '79312148432',
            'password' => Hash::make('radswad0'),
            'name' => 'Владимиров Алексей Сергеевич',
            'e1_card' => '7005230017154060063',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'denis.tilik@yandex.ru',
            'phone' => '79313219697',
            'password' => Hash::make('radswad0'),
            'name' => 'Тилик Денис Дмитриевич',
            'e1_card' => '7005230017154060055',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'dumtsev.igor@bk.ru',
            'phone' => '79210014828',
            'password' => Hash::make('radswad0'),
            'name' => 'Думцев Игорь Александрович',
            'e1_card' => '7005230017154060071',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 2,
            'email' => '9132900@gmail.com',
            'phone' => '79219132900',
            'password' => Hash::make('radswad0'),
            'name' => 'Клишевич Андрей Владимирович',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 2,
            'email' => 'naa@rlexport.ru',
            'phone' => '79218864280',
            'password' => Hash::make('radswad0'),
            'name' => 'Никандров Алексей Анатольевич',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 2,
            'email' => 'mli@rlexport.ru',
            'phone' => '79117719191',
            'password' => Hash::make('xu7Heme'),
            'name' => 'Мамина Лаура Игоревна',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'bykov@rlexport.ru',
            'phone' => '79212466953',
            'password' => Hash::make('radswad0'),
            'name' => 'Быков Иван Николаевич',
            'e1_card' => '7005230017154060097',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'maksimovivanmaz459@gmail.com',
            'phone' => '79214423011',
            'password' => Hash::make('radswad0'),
            'name' => 'Максимов Иван Владимирович',
            'e1_card' => '7005230017154060048',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'enter22866@gmail.com',
            'phone' => '79211898330',
            'password' => Hash::make('radswad0'),
            'name' => 'Молчанов Антон Александрович',
            'e1_card' => '7005230017154060113',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'viidas.viktor@yandex.ru',
            'phone' => '79117210092',
            'password' => Hash::make('radswad0'),
            'name' => 'Вийдас Виктор Юрьевич',
            'e1_card' => '7005230017154060089',
        ]);
    }
}

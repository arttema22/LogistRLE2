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
            'password' => Hash::make('1234qwerQWER'),
            'name' => 'system',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 1,
            'email' => 'arttema@mail.ru',
            'password' => Hash::make('1234qwerQWER'),
            'name' => 'Artem',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'haziullin.andrei@mail.ru',
            'password' => Hash::make('radswad0'),
            'name' => '060',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'smirnov@mail.ru',
            'password' => Hash::make('radswad0'),
            'name' => '548',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'sashok568@inbox.ru',
            'password' => Hash::make('radswad0'),
            'name' => '513',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'sachamol75@gmail.com',
            'password' => Hash::make('radswad0'),
            'name' => '185',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'lukin_vyacheslav@mail.ru',
            'password' => Hash::make('radswad0'),
            'name' => '101',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'aleksii.99@mail.ru',
            'password' => Hash::make('radswad0'),
            'name' => '396',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'alex-1884@mail.ru',
            'password' => Hash::make('radswad0'),
            'name' => '547',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'maiorov.ivan1986@mail.ru',
            'password' => Hash::make('radswad0'),
            'name' => '294',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'mers862@mail.ru',
            'password' => Hash::make('radswad0'),
            'name' => '931',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'vladimirov@inbox.ru',
            'password' => Hash::make('radswad0'),
            'name' => '097',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'tilik@inbox.ru',
            'password' => Hash::make('radswad0'),
            'name' => '792',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'dumtsev.igor@bk.ru',
            'password' => Hash::make('radswad0'),
            'name' => '280',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 2,
            'email' => '9132900@gmail.com',
            'password' => Hash::make('radswad0'),
            'name' => '9132900',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 2,
            'email' => 'naa@rlexport.ru',
            'password' => Hash::make('radswad0'),
            'name' => 'Alexyi',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 2,
            'email' => 'mli@rlexport.ru',
            'password' => Hash::make('xu7Heme'),
            'name' => 'mli',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'bykov@rlexport.ru',
            'password' => Hash::make('radswad0'),
            'name' => '269',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'maksimov@rlexport.ru',
            'password' => Hash::make('radswad0'),
            'name' => '579',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'sudarevne@ya.ru',
            'password' => Hash::make('radswad0'),
            'name' => '513',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'enter22866@gmail.com',
            'password' => Hash::make('radswad0'),
            'name' => '280',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'viidas.viktor@yandex.ru',
            'password' => Hash::make('radswad0'),
            'name' => 'viidas',
        ]);
    }
}

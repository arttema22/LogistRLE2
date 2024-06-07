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
            $table->string('password');
            $table->string('name');
            $table->string('avatar')->nullable();
            $table->string('remember_token', 100)->nullable();
        });

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
            'name' => 'Гусев А.А.',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'haziullin.andrei@mail.ru',
            'password' => Hash::make('radswad0'),
            'name' => 'Хазиуллин А.Р.',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'sachamol75@gmail.com',
            'password' => Hash::make('radswad0'),
            'name' => 'Молчанов А.А.',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'lukin_vyacheslav@mail.ru',
            'password' => Hash::make('radswad0'),
            'name' => 'Лукин В.В.',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'aleksii.99@mail.ru',
            'password' => Hash::make('radswad0'),
            'name' => 'Мещеряков А.Н.',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'alex-1884@mail.ru',
            'password' => Hash::make('radswad0'),
            'name' => 'Екимов А.С.',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'maiorov.ivan1986@mail.ru',
            'password' => Hash::make('radswad0'),
            'name' => 'Майоров И.Я.',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'mers862@mail.ru',
            'password' => Hash::make('radswad0'),
            'name' => 'Леонтьев А.А.',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'vladimirov@inbox.ru',
            'password' => Hash::make('radswad0'),
            'name' => 'Владимиров А.С.',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'denis.tilik@yandex.ru',
            'password' => Hash::make('radswad0'),
            'name' => 'Тилик Д.Д.',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'dumtsev.igor@bk.ru',
            'password' => Hash::make('radswad0'),
            'name' => 'Думцев И.А.',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 2,
            'email' => '9132900@gmail.com',
            'password' => Hash::make('radswad0'),
            'name' => 'Клишевич А.В.',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 2,
            'email' => 'naa@rlexport.ru',
            'password' => Hash::make('P1$t0let'),
            'name' => 'Никандров А.А.',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 2,
            'email' => 'mli@rlexport.ru',
            'password' => Hash::make('xu7Heme'),
            'name' => 'Мамина Л.И.',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'bykov@rlexport.ru',
            'password' => Hash::make('radswad0'),
            'name' => 'Быков И.Н.',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'maksimovivanmaz459@gmail.com',
            'password' => Hash::make('radswad0'),
            'name' => 'Максимов И.В.',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'enter22866@gmail.com',
            'password' => Hash::make('radswad0'),
            'name' => 'Молчанов А.А.',
        ]);

        MoonshineUser::create([
            'moonshine_user_role_id' => 3,
            'email' => 'viidas.viktor@yandex.ru',
            'password' => Hash::make('radswad0'),
            'name' => 'Вийдас В.Ю.',
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

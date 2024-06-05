<?php

use App\Models\Dir\DirRouteAddress;
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
        Schema::create('dir_route_addresses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name')->unique();
            $table->softDeletes();
        });

        DirRouteAddress::create([
            'name' => 'Авангардная',
        ]);
        DirRouteAddress::create([
            'name' => 'Аннино',
        ]);
        DirRouteAddress::create([
            'name' => 'Александровская горка',
        ]);
        DirRouteAddress::create([
            'name' => 'Алтун',
        ]);
        DirRouteAddress::create([
            'name' => 'Атрубашка',
        ]);
        DirRouteAddress::create([
            'name' => 'Афаносово',
        ]);
        DirRouteAddress::create([
            'name' => 'Б. Вруда',
        ]);
        DirRouteAddress::create([
            'name' => 'Б.поля',
        ]);
        DirRouteAddress::create([
            'name' => 'Б. Кузëмкино',
        ]);
        DirRouteAddress::create([
            'name' => 'Бакор',
        ]);
        DirRouteAddress::create([
            'name' => 'Бегма',
        ]);
        DirRouteAddress::create([
            'name' => 'Белая горка',
        ]);
        DirRouteAddress::create([
            'name' => 'Белогорка',
        ]);
        DirRouteAddress::create([
            'name' => 'Березно',
        ]);
        DirRouteAddress::create([
            'name' => 'Берёзка',
        ]);
        DirRouteAddress::create([
            'name' => 'Большие Луки',
        ]);
        DirRouteAddress::create([
            'name' => 'Брянск',
        ]);
        DirRouteAddress::create([
            'name' => 'Будани',
        ]);
        DirRouteAddress::create([
            'name' => 'Будилово',
        ]);
        DirRouteAddress::create([
            'name' => 'Вак пнок Волосово',
        ]);
        DirRouteAddress::create([
            'name' => 'Васильевско',
        ]);
        DirRouteAddress::create([
            'name' => 'Вейно (Добручи, Гдовский р-н)',
        ]);
        DirRouteAddress::create([
            'name' => 'Великие Луки',
        ]);
        DirRouteAddress::create([
            'name' => 'Верест',
        ]);
        DirRouteAddress::create([
            'name' => 'Вологда',
        ]);
        DirRouteAddress::create([
            'name' => 'Волосово',
        ]);
        DirRouteAddress::create([
            'name' => 'Войносолово',
        ]);
        DirRouteAddress::create([
            'name' => 'Волхонское шоссе 6',
        ]);
        DirRouteAddress::create([
            'name' => 'Волхонское ш.6 ( ч/з Б. Вруду )',
        ]);
        DirRouteAddress::create([
            'name' => 'Волхонское ш.6 (ч/з Кобралово)',
        ]);
        DirRouteAddress::create([
            'name' => 'Вруда',
        ]);
        DirRouteAddress::create([
            'name' => 'Волхов',
        ]);
        DirRouteAddress::create([
            'name' => 'Выборг',
        ]);
        DirRouteAddress::create([
            'name' => 'Выра',
        ]);
        DirRouteAddress::create([
            'name' => 'Выскатка',
        ]);
        DirRouteAddress::create([
            'name' => 'Гродно',
        ]);
        DirRouteAddress::create([
            'name' => 'Ганьково',
        ]);
        DirRouteAddress::create([
            'name' => 'Гверездка',
        ]);
        DirRouteAddress::create([
            'name' => 'Гдов',
        ]);
        DirRouteAddress::create([
            'name' => 'Глинки',
        ]);
        DirRouteAddress::create([
            'name' => 'Гусева гора',
        ]);
        DirRouteAddress::create([
            'name' => 'Глубокое',
        ]);
        DirRouteAddress::create([
            'name' => 'Городовик',
        ]);
        DirRouteAddress::create([
            'name' => 'Гридино',
        ]);
        DirRouteAddress::create([
            'name' => 'Данилово',
        ]);
        DirRouteAddress::create([
            'name' => 'Дедино',
        ]);
        DirRouteAddress::create([
            'name' => 'Дедовичи',
        ]);
        DirRouteAddress::create([
            'name' => 'Демешкин Перевоз',
        ]);
        DirRouteAddress::create([
            'name' => 'Демешкино',
        ]);
        DirRouteAddress::create([
            'name' => 'Добручи',
        ]);
        DirRouteAddress::create([
            'name' => 'Дорожная 1',
        ]);
        DirRouteAddress::create([
            'name' => 'Дубоем',
        ]);
        DirRouteAddress::create([
            'name' => 'Дубок',
        ]);
        DirRouteAddress::create([
            'name' => 'Дуброво',
        ]);
        DirRouteAddress::create([
            'name' => 'Дубяги',
        ]);
        DirRouteAddress::create([
            'name' => 'Дорога на Металлострой 3',
        ]);
        DirRouteAddress::create([
            'name' => 'Елемно',
        ]);
        DirRouteAddress::create([
            'name' => 'Егорьевск',
        ]);
        DirRouteAddress::create([
            'name' => 'Елизаветино',
        ]);
        DirRouteAddress::create([
            'name' => 'Жадрицы',
        ]);
        DirRouteAddress::create([
            'name' => 'Жилино',
        ]);
        DirRouteAddress::create([
            'name' => 'Жуково (Гдов)',
        ]);
        DirRouteAddress::create([
            'name' => 'Журавлев конец',
        ]);
        DirRouteAddress::create([
            'name' => 'Завердужье',
        ]);
        DirRouteAddress::create([
            'name' => 'Загорье',
        ]);
        DirRouteAddress::create([
            'name' => 'Заклинье',
        ]);
        DirRouteAddress::create([
            'name' => 'Замежье',
        ]);
        DirRouteAddress::create([
            'name' => 'Замошье (кусты)',
        ]);
        DirRouteAddress::create([
            'name' => 'Заовражье',
        ]);
        DirRouteAddress::create([
            'name' => 'Заплюсье',
        ]);
        DirRouteAddress::create([
            'name' => 'Заручье',
        ]);
        DirRouteAddress::create([
            'name' => 'Заяцково',
        ]);
        DirRouteAddress::create([
            'name' => 'Зуево',
        ]);
        DirRouteAddress::create([
            'name' => 'Ивангород',
        ]);
        DirRouteAddress::create([
            'name' => 'Ивановское',
        ]);
        DirRouteAddress::create([
            'name' => 'Идрица',
        ]);
        DirRouteAddress::create([
            'name' => 'Идрица-Пустошка(Пск.Обл)',
        ]);
        DirRouteAddress::create([
            'name' => 'Инок Волосово',
        ]);
        DirRouteAddress::create([
            'name' => 'Исаково Псковской. Обл.',
        ]);
        DirRouteAddress::create([
            'name' => 'Игоревская',
        ]);
        DirRouteAddress::create([
            'name' => 'Калливере',
        ]);
        DirRouteAddress::create([
            'name' => 'Кательский',
        ]);
        DirRouteAddress::create([
            'name' => 'Кезелево(Гатчин. р-н)',
        ]);
        DirRouteAddress::create([
            'name' => 'Камено',
        ]);
        DirRouteAddress::create([
            'name' => 'Карьер',
        ]);
        DirRouteAddress::create([
            'name' => 'Кингисепп',
        ]);
        DirRouteAddress::create([
            'name' => 'Клуколова',
        ]);
        DirRouteAddress::create([
            'name' => 'Комсомольское ш',
        ]);
        DirRouteAddress::create([
            'name' => 'Красные Борки',
        ]);
        DirRouteAddress::create([
            'name' => 'Княжево',
        ]);
        DirRouteAddress::create([
            'name' => 'Кобралово',
        ]);
        DirRouteAddress::create([
            'name' => 'Ковалёво',
        ]);
        DirRouteAddress::create([
            'name' => 'Кузëмкино',
        ]);
        DirRouteAddress::create([
            'name' => 'Куровицы',
        ]);
        DirRouteAddress::create([
            'name' => 'Кривко',
        ]);
        DirRouteAddress::create([
            'name' => 'Крюки',
        ]);
        DirRouteAddress::create([
            'name' => 'Колпинское шоссе 38 ',
        ]);
        DirRouteAddress::create([
            'name' => 'Коммунар Строителей 3',
        ]);
        DirRouteAddress::create([
            'name' => 'Комсомольское ш. д.13',
        ]);
        DirRouteAddress::create([
            'name' => 'Котлы',
        ]);
        DirRouteAddress::create([
            'name' => 'Кошкино Парк',
        ]);
        DirRouteAddress::create([
            'name' => 'Красногородск',
        ]);
        DirRouteAddress::create([
            'name' => 'Красный Бор',
        ]);
        DirRouteAddress::create([
            'name' => 'Левашово',
        ]);
        DirRouteAddress::create([
            'name' => 'Лебяжье',
        ]);
        DirRouteAddress::create([
            'name' => 'Лесное',
        ]);
        DirRouteAddress::create([
            'name' => 'Лисино-Корпус',
        ]);
        DirRouteAddress::create([
            'name' => 'Ломоносов',
        ]);
        DirRouteAddress::create([
            'name' => 'Луга',
        ]);
        DirRouteAddress::create([
            'name' => 'Лужицы',
        ]);
        DirRouteAddress::create([
            'name' => 'Лужицы (ч/з Б.Вруду)',
        ]);
        DirRouteAddress::create([
            'name' => 'Лучки',
        ]);
        DirRouteAddress::create([
            'name' => 'Липы',
        ]);
        DirRouteAddress::create([
            'name' => 'Лисий нос',
        ]);
        DirRouteAddress::create([
            'name' => 'Лопец',
        ]);
        DirRouteAddress::create([
            'name' => 'Любочажье',
        ]);
        DirRouteAddress::create([
            'name' => 'Любытино',
        ]);
        DirRouteAddress::create([
            'name' => 'Максютино',
        ]);
        DirRouteAddress::create([
            'name' => 'Малый Луцк',
        ]);
        DirRouteAddress::create([
            'name' => 'Малышева гора',
        ]);
        DirRouteAddress::create([
            'name' => 'Медвежек',
        ]);
        DirRouteAddress::create([
            'name' => 'Мозули',
        ]);
        DirRouteAddress::create([
            'name' => 'Моклочно',
        ]);
        DirRouteAddress::create([
            'name' => 'Монастырёк',
        ]);
        DirRouteAddress::create([
            'name' => 'Московское шоссе 235 литер л',
        ]);
        DirRouteAddress::create([
            'name' => 'Мурино',
        ]);
        DirRouteAddress::create([
            'name' => 'Мшинская',
        ]);
        DirRouteAddress::create([
            'name' => 'Мышкино',
        ]);
        DirRouteAddress::create([
            'name' => 'Невель',
        ]);
        DirRouteAddress::create([
            'name' => 'Негуба',
        ]);
        DirRouteAddress::create([
            'name' => 'Неёлово',
        ]);
        DirRouteAddress::create([
            'name' => 'Новгород',
        ]);
        DirRouteAddress::create([
            'name' => 'Новое Девяткино',
        ]);
        DirRouteAddress::create([
            'name' => 'Новоселье',
        ]);
        DirRouteAddress::create([
            'name' => 'Новоселье (Псковская обл)',
        ]);
        DirRouteAddress::create([
            'name' => 'Новоселье (Струги)',
        ]);
        DirRouteAddress::create([
            'name' => 'Новый',
        ]);
        DirRouteAddress::create([
            'name' => 'Овсище',
        ]);
        DirRouteAddress::create([
            'name' => 'Окуловка',
        ]);
        DirRouteAddress::create([
            'name' => 'Опочка',
        ]);
        DirRouteAddress::create([
            'name' => 'Осьмино',
        ]);
        DirRouteAddress::create([
            'name' => 'Партизанская 14',
        ]);
        DirRouteAddress::create([
            'name' => 'Подозванье',
        ]);
        DirRouteAddress::create([
            'name' => 'Полна',
        ]);
        DirRouteAddress::create([
            'name' => 'Порхов',
        ]);
        DirRouteAddress::create([
            'name' => 'Посёлок Новый',
        ]);
        DirRouteAddress::create([
            'name' => 'Посёлок Плюсса',
        ]);
        DirRouteAddress::create([
            'name' => 'Потрехново',
        ]);
        DirRouteAddress::create([
            'name' => 'Псков',
        ]);
        DirRouteAddress::create([
            'name' => 'Псков (ул.Декабристов)',
        ]);
        DirRouteAddress::create([
            'name' => 'Псков Леона Поземского',
        ]);
        DirRouteAddress::create([
            'name' => 'Псков(Новаторов3г)',
        ]);
        DirRouteAddress::create([
            'name' => 'Пустомержское поселения',
        ]);
        DirRouteAddress::create([
            'name' => 'Пушкин Тярлево',
        ]);
        DirRouteAddress::create([
            'name' => 'Р.Верца',
        ]);
        DirRouteAddress::create([
            'name' => 'Разбегаево',
        ]);
        DirRouteAddress::create([
            'name' => 'Ремонтников 1',
        ]);
        DirRouteAddress::create([
            'name' => 'Реполка',
        ]);
        DirRouteAddress::create([
            'name' => 'Рудница',
        ]);
        DirRouteAddress::create([
            'name' => 'Рудно',
        ]);
        DirRouteAddress::create([
            'name' => 'Рыбацкий пр 3',
        ]);
        DirRouteAddress::create([
            'name' => 'Сабск',
        ]);
        DirRouteAddress::create([
            'name' => 'Сара-Лог',
        ]);
        DirRouteAddress::create([
            'name' => 'Сельхозтехника (СХТ)',
        ]);
        DirRouteAddress::create([
            'name' => 'Сергеиха',
        ]);
        DirRouteAddress::create([
            'name' => 'Серебрянский',
        ]);
        DirRouteAddress::create([
            'name' => 'Середка',
        ]);
        DirRouteAddress::create([
            'name' => 'Сертолово',
        ]);
        DirRouteAddress::create([
            'name' => 'Сестрорецк',
        ]);
        DirRouteAddress::create([
            'name' => 'Симонова 15',
        ]);
        DirRouteAddress::create([
            'name' => 'Славянка',
        ]);
        DirRouteAddress::create([
            'name' => 'Славянская',
        ]);
        DirRouteAddress::create([
            'name' => 'Сланцы',
        ]);
        DirRouteAddress::create([
            'name' => 'Слипченко',
        ]);
        DirRouteAddress::create([
            'name' => 'Смоленец',
        ]);
        DirRouteAddress::create([
            'name' => 'Сольцы Новгородская обл',
        ]);
        DirRouteAddress::create([
            'name' => 'Сортавала',
        ]);
        DirRouteAddress::create([
            'name' => 'Сосново',
        ]);
        DirRouteAddress::create([
            'name' => 'Сосновый Бор',
        ]);
        DirRouteAddress::create([
            'name' => 'СПб, Лесопарковая 15',
        ]);
        DirRouteAddress::create([
            'name' => 'Ст. Сланцы',
        ]);
        DirRouteAddress::create([
            'name' => 'Стаи',
        ]);
        DirRouteAddress::create([
            'name' => 'Старополье',
        ]);
        DirRouteAddress::create([
            'name' => 'Струги Красные',
        ]);
        DirRouteAddress::create([
            'name' => 'Тëсово-Нетыльское',
        ]);
        DirRouteAddress::create([
            'name' => 'Тамегонт',
        ]);
        DirRouteAddress::create([
            'name' => 'Угольная гавань',
        ]);
        DirRouteAddress::create([
            'name' => 'Уйсолово',
        ]);
        DirRouteAddress::create([
            'name' => 'Ул.ремонтников 1',
        ]);
        DirRouteAddress::create([
            'name' => 'Усть-Ижора',
        ]);
        DirRouteAddress::create([
            'name' => 'Усть-Луга',
        ]);
        DirRouteAddress::create([
            'name' => 'Цапелька',
        ]);
        DirRouteAddress::create([
            'name' => 'Цесла',
        ]);
        DirRouteAddress::create([
            'name' => 'Черенское',
        ]);
        DirRouteAddress::create([
            'name' => 'Чернëво',
        ]);
        DirRouteAddress::create([
            'name' => 'Чернецово',
        ]);
        DirRouteAddress::create([
            'name' => 'Чудиново',
        ]);
        DirRouteAddress::create([
            'name' => 'Чудово',
        ]);
        DirRouteAddress::create([
            'name' => 'Шавково',
        ]);
        DirRouteAddress::create([
            'name' => 'Шакицы',
        ]);
        DirRouteAddress::create([
            'name' => 'Шовково',
        ]);
        DirRouteAddress::create([
            'name' => 'Шушары',
        ]);
        DirRouteAddress::create([
            'name' => 'Яблонька',
        ]);
        DirRouteAddress::create([
            'name' => 'Язвище',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dir_route_addresses');
    }
};

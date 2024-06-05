<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Tariff\TariffRoute;

use MoonShine\Fields\Number;
use MoonShine\Decorations\Flex;
use MoonShine\Decorations\Block;
use App\MoonShine\Pages\Crud\FormPageCustom;
use MoonShine\Fields\Relationships\BelongsTo;
use App\MoonShine\Resources\Dir\DirRouteAddressResource;

class TariffRouteFormPage extends FormPageCustom
{
    /**
     * getAlias
     * Устанавливает алиас для ресурса.
     * @return string
     */
    public function getAlias(): ?string
    {
        return __('moonshine::tariff.resource_form');
    }

    /**
     * fields
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Block::make([
                Flex::make([
                    BelongsTo::make(
                        'start',
                        'start',
                        resource: new DirRouteAddressResource()
                    )->nullable()->required()->searchable()
                        ->translatable('moonshine::tariff'),
                    BelongsTo::make(
                        'finish',
                        'finish',
                        resource: new DirRouteAddressResource()
                    )->nullable()->required()->searchable()
                        ->translatable('moonshine::tariff'),
                    Number::make('length')->step(1)->expansion('км.')->translatable('moonshine::tariff'),
                    Number::make('price')->step(.01)->expansion('руб.')->translatable('moonshine::tariff'),
                ]),
            ]),
        ];
    }
}

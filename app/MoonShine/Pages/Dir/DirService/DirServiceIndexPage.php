<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Dir\DirService;

use MoonShine\Fields\Text;
use MoonShine\Fields\Position;
use MoonShine\Pages\Crud\IndexPage;

class DirServiceIndexPage extends IndexPage
{
    /**
     * getAlias
     * Устанавливает алиас для ресурса.
     * @return string
     */
    public function getAlias(): ?string
    {
        return __('moonshine::directory.resource_list');
    }

    /**
     * fields
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Position::make(),
            Text::make('name')->sortable()->translatable('moonshine::directory'),
            Text::make('price')->sortable()->translatable('moonshine::directory'),
        ];
    }
}

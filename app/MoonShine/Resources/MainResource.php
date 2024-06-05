<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use MoonShine\Enums\Layer;
use MoonShine\Enums\PageType;
use MoonShine\Handlers\ExportHandler;
use MoonShine\Handlers\ImportHandler;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use MoonShine\ChangeLog\Components\ChangeLog;

class MainResource extends ModelResource
{
    // Проверка прав доступа
    protected bool $withPolicy = false;

    // Редирект после сохранения
    protected ?PageType $redirectAfterSave = PageType::INDEX;

    // Редирект после удаления
    protected ?PageType $redirectAfterDelete = PageType::INDEX;

    // Количество элементов на странице
    protected int $itemsPerPage = 15;

    /**
     * getActiveActions
     * Разрешенные действия
     * @return array
     */
    public function getActiveActions(): array
    {
        return [
            'create', 'update', 'view', 'delete'
        ];
    }

    /**
     * rules
     * Правила проверки вводимых данных
     * @param  mixed $item
     * @return array
     */
    public function rules(Model $item): array
    {
        return [];
    }

    /**
     * import
     * Импорт данных
     * @return ImportHandler
     */
    public function import(): ?ImportHandler
    {
        return null;
    }

    /**
     * export
     * Экспорт данных
     * @return ExportHandler
     */
    public function export(): ?ExportHandler
    {
        return null;
    }

    /**
     * onBoot
     * Логирование изменений
     * @return void
     */
    protected function onBoot(): void
    {
        $this->getPages()
            ->formPage()
            ->pushToLayer(
                Layer::BOTTOM,
                ChangeLog::make('Changelog', $this)
            );
    }
}

<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Sys;

use MoonShine\Fields\Url;
use MoonShine\Fields\Json;
use MoonShine\Fields\Text;
use MoonShine\Enums\PageType;
use MoonShine\Attributes\Icon;
use MoonShine\Fields\Textarea;
use App\Models\Sys\SetupIntegration;
use MoonShine\Decorations\Block;
use MoonShine\Handlers\ExportHandler;
use MoonShine\Handlers\ImportHandler;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends ModelResource<SetupIntegration>
 */
#[Icon('heroicons.outline.wrench-screwdriver')]
class SetupIntegrationResource extends ModelResource
{
    // Модель данных
    protected string $model = SetupIntegration::class;

    // Проверка прав доступа
    protected bool $withPolicy = false;

    // Редирект после сохранения
    protected ?PageType $redirectAfterSave = PageType::INDEX;

    // Редирект после удаления
    protected ?PageType $redirectAfterDelete = PageType::INDEX;

    // Поле сортировки по умолчанию
    protected string $sortColumn = 'name';

    // Тип сортировки по умолчанию
    protected string $sortDirection = 'ASC';

    // Количество элементов на странице
    protected int $itemsPerPage = 15;

    // Поле для отображения значений в связях и хлебных крошках
    public string $column = 'name';

    public function title(): string
    {
        return __('moonshine::integration.integrations');
    }

    // Разрешенные действия
    public function getActiveActions(): array
    {
        return [
            'create', 'update', 'delete'
        ];
    }

    public function indexFields(): array
    {
        return [
            Text::make('name')
                ->sortable()
                ->translatable('moonshine::integration.setup'),
            Text::make(
                'help',
                'help_api',
                fn ($item) => '<a href="' . $item['help_api'] . '" target=_blank>link</a>'
            )->translatable('moonshine::integration.setup'),
        ];
    }

    public function formFields(): array
    {
        return [
            Block::make([
                Text::make('name')->required()->translatable('moonshine::integration.setup'),
                Url::make('url')->expansion('url')->required()->translatable('moonshine::integration.setup'),
                Text::make('user_name')->translatable('moonshine::integration.setup'),
                Text::make('password')->eye()->translatable('moonshine::integration.setup'),
                Textarea::make('access_token')->translatable('moonshine::integration.setup'),
                Json::make('additionally')->keyValue()->removable()->translatable('moonshine::integration.setup'),
                Textarea::make('comment')->translatable('moonshine::integration.setup'),
            ]),
        ];
    }

    public function rules(Model $item): array
    {
        return [
            'name' => ['required', 'string', 'min:3'],
            'url' => ['required', 'url'],
        ];
    }

    public function import(): ?ImportHandler
    {
        return null;
    }

    public function export(): ?ExportHandler
    {
        return null;
    }
}

<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use MoonShine\Fields\ID;
use MoonShine\Fields\Url;

use MoonShine\Fields\Json;
use MoonShine\Fields\Text;
use MoonShine\Fields\Password;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Textarea;
use App\Models\SetupIntegration;
use MoonShine\Handlers\ExportHandler;
use MoonShine\Handlers\ImportHandler;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends ModelResource<SetupIntegration>
 */
class SetupIntegrationResource extends ModelResource
{
    protected string $model = SetupIntegration::class;

    //protected bool $withPolicy = true;

    public function title(): string
    {
        return __('moonshine::integration.integrations');
    }

    public string $column = 'name';

    public function indexFields(): array
    {
        return [
            Text::make('name')->translatable('moonshine::integration.setup'),
            Text::make(
                'help_api',
                'help_api',
                fn ($item) => '<a href="' . $item->help_api . '" target="_blank">' . __('moonshine::integration.setup.manual') . '</a>'
            )->translatable('moonshine::integration.setup'),

            Switcher::make('status')->updateOnPreview()->translatable('moonshine::integration.setup'),
        ];
    }

    public function formFields(): array
    {
        return [
            Text::make('name')->required()->translatable('moonshine::integration.setup'),
            Url::make('url')->expansion('url')->required()->translatable('moonshine::integration.setup'),
            Text::make('user_name')->translatable('moonshine::integration.setup'),
            Text::make('password')->eye()->translatable('moonshine::integration.setup'),
            Textarea::make('access_token')->translatable('moonshine::integration.setup'),
            Json::make('additionally')->keyValue()->removable()->translatable('moonshine::integration.setup'),
            Textarea::make('comment')->translatable('moonshine::integration.setup'),
            Switcher::make('status')->translatable('moonshine::integration.setup'),
        ];
    }

    public function rules(Model $item): array
    {
        return [
            'name' => ['required', 'string'],
            'url' => ['required', 'url'],
            'status' => ['boolean'],
        ];
    }

    /*
    * перенаправление после сохранения
    */
    public function redirectAfterSave(): string
    {
        return to_page(resource: SetupIntegrationResource::class);
    }

    /*
    * разрешенные действия
    */
    public function getActiveActions(): array
    {
        return ['create', 'update', 'delete', 'massDelete'];
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

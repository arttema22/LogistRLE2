<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Profit;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\MoonShine\Pages\Profit\ProfitFormPage;

use App\MoonShine\Pages\Profit\ProfitIndexPage;
use App\MoonShine\Pages\Profit\ProfitDetailPage;

/**
 * @extends ModelResource<Profit>
 */
class ProfitResource extends ModelResource
{
    protected string $model = Profit::class;

    protected string $title = 'Profits';

    /**
     * query
     *
     * @return Builder
     */
    public function query(): Builder
    {
        return parent::query()->with('driver');
    }

    public function pages(): array
    {
        return [
            ProfitIndexPage::make($this->title()),
            ProfitFormPage::make(
                $this->getItemID()
                    ? __('moonshine::ui.edit')
                    : __('moonshine::ui.add')
            ),
            ProfitDetailPage::make(__('moonshine::ui.show')),
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }
}

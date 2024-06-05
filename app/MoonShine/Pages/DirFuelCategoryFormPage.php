<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use MoonShine\Pages\Page;
use MoonShine\Fields\Text;
use MoonShine\Fields\Position;
use MoonShine\Decorations\Grid;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\TypeCasts\ModelCast;
use App\Models\Dir\DirFuelCategory;
use MoonShine\Decorations\Fragment;
use MoonShine\Components\FormBuilder;
use MoonShine\Components\TableBuilder;
use MoonShine\ActionButtons\ActionButton;
use MoonShine\Components\MoonShineComponent;

class DirFuelCategoryFormPage extends Page
{
    /**
     * @return array<string, string>
     */
    public function breadcrumbs(): array
    {
        return [
            '#' => $this->title()
        ];
    }

    public function title(): string
    {
        return $this->title ?: 'DirFuelCategoryFormPage';
    }

    /**
     * @return list<MoonShineComponent>
     */
    public function components(): array
    {
        $item = DirFuelCategory::query()->find(request('id'));

        return [
            Grid::make([
                Column::make([
                    Block::make([
                        TableBuilder::make()
                            ->creatable(
                                icon: 'heroicons.outline.pencil',
                                attributes: ['class' => 'my-class']
                            )
                            ->fields([
                                Position::make(),
                                Text::make('name'),
                            ])
                            ->items(DirFuelCategory::query()->get())
                            ->cast(ModelCast::make(DirFuelCategory::class))
                            ->buttons([
                                ActionButton::make(
                                    '',
                                    fn (DirFuelCategory $dirFuelCategory)
                                    => $this->fragmentLoadUrl('content', ['id' => $dirFuelCategory->getKey()])
                                )
                                    ->async(selector: '#content')
                                    ->icon('heroicons.outline.pencil')
                            ])
                            ->withNotFound()
                    ]),
                ])->columnSpan(6),
                Column::make([
                    Fragment::make([
                        FormBuilder::make()
                            ->fields([
                                Block::make([
                                    Text::make('name')
                                ])
                            ])
                            ->fillCast(
                                $item?->toArray() ?? [],
                                ModelCast::make(DirFuelCategory::class)
                            )
                    ])->name('content')->customAttributes([
                        'id' => 'content'
                    ])
                ])->columnSpan(6),
            ])
        ];
    }
}

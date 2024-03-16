<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Refilling;

use MoonShine\Fields\Date;
use MoonShine\Fields\Text;
use MoonShine\Fields\Field;
use MoonShine\Enums\JsEvent;
use MoonShine\Fields\Fields;
use MoonShine\Fields\Hidden;
use MoonShine\Fields\Number;
use MoonShine\Decorations\Grid;
use MoonShine\Support\AlpineJs;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Pages\Crud\FormPage;
use MoonShine\Pages\Crud\IndexPage;
use Illuminate\Support\Facades\Auth;
use MoonShine\Components\FormBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use MoonShine\ActionButtons\ActionButton;
use App\MoonShine\Resources\TruckResource;
use MoonShine\Contracts\MoonShineRenderable;
use MoonShine\Fields\Relationships\BelongsTo;
use App\MoonShine\Resources\RefillingResource;
use App\MoonShine\Resources\MoonShineUserResource;
use App\MoonShine\Resources\DirPetrolStationResource;

class RefillingFormPage extends FormPage
{
    public function getAlias(): ?string
    {
        return __('moonshine::refilling.form_page');
    }

    public function fields(): array
    {
        return [
            Block::make([
                BelongsTo::make('driver', 'driver', resource: new MoonShineUserResource())
                    ->valuesQuery(fn (Builder $query, Field $field) => $query->where('moonshine_user_role_id', 3))
                    ->required()
                    ->nullable()
                    ->translatable('moonshine::refilling')
                    ->when(
                        fn () => Auth::user()->moonshine_user_role_id == 3,
                        fn (Field $field) => $field->hideOnForm(),
                    ),
                BelongsTo::make(
                    'petrol_station',
                    'petrolStation',
                    fn ($item) => $item->petrolStationBrand->name . ' | ' . $item->address,
                    resource: new DirPetrolStationResource()
                )
                    ->required()
                    ->nullable()
                    ->searchable()
                    ->translatable('moonshine::refilling'),
                BelongsTo::make(
                    'truck',
                    'truck',
                    fn ($item) => "$item->name \ $item->reg_num",
                    resource: new TruckResource()
                )->searchable()
                    ->nullable()
                    ->translatable('moonshine::refilling'),
                Grid::make([
                    Column::make([
                        Date::make('date')->required()
                            ->translatable('moonshine::refilling'),
                    ])->columnSpan(6),
                    Column::make([
                        Number::make('volume')->required()
                            ->min(10)->max(9999999.99)->step(0.01)
                            ->translatable('moonshine::refilling'),
                    ])->columnSpan(6),
                ]),
                Text::make('comment')->translatable('moonshine::refilling'),
            ]),
        ];
    }

    protected function formComponent(string $action, ?Model $item, Fields $fields, bool $isAsync = false): MoonShineRenderable
    {
        $resource = $this->getResource();

        return FormBuilder::make($action)
            ->fillCast(
                $item,
                $resource->getModelCast()
            )
            ->fields(
                $fields
                    ->when(
                        !is_null($item),
                        fn (Fields $fields): Fields => $fields->push(
                            Hidden::make('_method')->setValue('PUT')
                        )
                    )
                    ->when(
                        !$item?->exists && !$resource->isCreateInModal(),
                        fn (Fields $fields): Fields => $fields->push(
                            Hidden::make('_force_redirect')->setValue(true)
                        )
                    )
                    ->toArray()
            )
            ->when(
                $isAsync,
                fn (FormBuilder $formBuilder): FormBuilder => $formBuilder
                    ->async(asyncEvents: [
                        $resource->listEventName(request('_component_name', 'default')),
                        AlpineJs::event(JsEvent::FORM_RESET, 'crud'),
                    ])
            )
            ->when(
                $resource->isPrecognitive() || (moonshineRequest()->isFragmentLoad('crud-form') && !$isAsync),
                fn (FormBuilder $form): FormBuilder => $form->precognitive()
            )
            ->name('crud')
            ->submit(__('moonshine::ui.save'), ['class' => 'btn-primary btn-lg'])
            ->buttons([
                ActionButton::make('cancel', to_page(page: IndexPage::class, resource: RefillingResource::class))
                    ->translatable('moonshine::ui')
            ]);
    }

    protected function topLayer(): array
    {
        return [
            ...parent::topLayer()
        ];
    }

    protected function mainLayer(): array
    {
        return [
            ...parent::mainLayer()
        ];
    }

    protected function bottomLayer(): array
    {
        return [
            ...parent::bottomLayer()
        ];
    }
}

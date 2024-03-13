<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Salary;

use MoonShine\Fields\Date;
use MoonShine\Fields\Text;
use MoonShine\Fields\Field;
use Illuminate\Http\Request;
use MoonShine\Enums\JsEvent;
use MoonShine\Fields\Fields;
use MoonShine\Fields\Hidden;
use MoonShine\Fields\Number;
use MoonShine\Fields\Preview;
use MoonShine\Fields\Textarea;
use MoonShine\Decorations\Grid;
use MoonShine\Support\AlpineJs;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Pages\Crud\FormPage;
use MoonShine\Pages\Crud\IndexPage;
use Illuminate\Support\Facades\Auth;
use MoonShine\Decorations\LineBreak;
use MoonShine\Components\FormBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use MoonShine\ActionButtons\ActionButton;
use App\MoonShine\Resources\SalaryResource;
use MoonShine\Contracts\MoonShineRenderable;
use MoonShine\Fields\Relationships\BelongsTo;
use App\MoonShine\Resources\MoonShineUserResource;

class SalaryFormPage extends FormPage
{
    public function getAlias(): ?string
    {
        return __('moonshine::salary.form_page');
    }

    public function fields(): array
    {
        return [
            Block::make([
                BelongsTo::make('driver', 'driver', resource: new MoonShineUserResource())
                    ->valuesQuery(fn (Builder $query, Field $field) => $query->where('moonshine_user_role_id', 3))
                    ->required()
                    ->nullable()
                    ->translatable('moonshine::salary')
                    ->when(
                        Auth::user()->moonshine_user_role_id === 3,
                        fn (Field $field) => $field->hideOnForm(),
                    ),
                Grid::make([
                    Column::make([
                        Date::make('date')->required()
                            ->translatable('moonshine::salary'),
                    ])->columnSpan(6),
                    Column::make([
                        Number::make('salary')->required()
                            ->min(10)->max(9999999.99)->step(0.01)
                            ->translatable('moonshine::salary'),
                    ])->columnSpan(6),
                ]),
                Text::make('comment')->translatable('moonshine::salary'),
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
                ActionButton::make('cancel', to_page(page: IndexPage::class, resource: SalaryResource::class))
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
            ...parent::bottomLayer(),
            LineBreak::make(),
            Preview::make()
                ->badge('warning')
                ->link('https://github.com/arttema22/LogistRLE2/wiki/%D0%92%D1%8B%D0%BF%D0%BB%D0%B0%D1%82%D1%8B', __('moonshine::ui.help'), blank: true)
        ];
    }
}

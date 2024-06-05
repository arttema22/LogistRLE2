<?php

namespace App\MoonShine\Pages\Crud;

use MoonShine\Enums\JsEvent;
use MoonShine\Fields\Fields;
use MoonShine\Fields\Hidden;
use MoonShine\Support\AlpineJs;
use MoonShine\Pages\Crud\FormPage;
use MoonShine\Components\FormBuilder;
use Illuminate\Database\Eloquent\Model;
use MoonShine\ActionButtons\ActionButton;
use MoonShine\Contracts\MoonShineRenderable;

class FormPageCustom extends FormPage
{
    /**
     * formComponent
     *
     * @param  mixed $action
     * @param  mixed $item
     * @param  mixed $fields
     * @param  mixed $isAsync
     * @return MoonShineRenderable
     */
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
                ActionButton::make('cancel', $resource->indexPageUrl())
                    ->translatable('moonshine::ui'),
            ]);
    }

    /**
     * topLayer
     * Таким образом убираем кнопки в верхней части формы ("удалить")
     * @return array
     */
    protected function topLayer(): array
    {
        return [];
    }
}

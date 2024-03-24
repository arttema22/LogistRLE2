<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Sys;

use MoonShine\Fields\ID;
use MoonShine\Fields\Date;
use MoonShine\Fields\Text;
use MoonShine\Fields\Email;
use MoonShine\Fields\Phone;
use MoonShine\Enums\PageType;
use MoonShine\Attributes\Icon;
use MoonShine\Decorations\Tab;
use MoonShine\Fields\Password;
use Illuminate\Validation\Rule;
use MoonShine\Decorations\Tabs;
use MoonShine\Decorations\Block;
use MoonShine\Fields\StackFields;
use MoonShine\Decorations\Heading;
use MoonShine\Models\MoonshineUser;
use MoonShine\Fields\PasswordRepeat;
use MoonShine\Resources\ModelResource;
use MoonShine\Models\MoonshineUserRole;
use MoonShine\Fields\Relationships\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use App\MoonShine\Resources\Sys\MoonShineUserRoleResource;

/**
 * @extends ModelResource<MoonshineUser>
 */
#[Icon('heroicons.outline.users')]
class MoonShineUserResource extends ModelResource
{
    public string $model = MoonshineUser::class;

    public string $column = 'name';

    public array $with = ['moonshineUserRole'];

    protected bool $withPolicy = false; // Проверка прав доступа

    protected string $sortColumn = 'name'; // Поле сортировки по умолчанию

    protected string $sortDirection = 'ASC'; // Тип сортировки по умолчанию

    public function title(): string
    {
        return __('moonshine::ui.resource.title');
    }

    // редиректы после создания и удаления
    protected ?PageType $redirectAfterSave = PageType::INDEX;
    protected ?PageType $redirectAfterDelete = PageType::INDEX;

    public function query(): Builder
    {
        if (Auth()->user()->moonshine_user_role_id === 1)
            // SuperAdmin видит всех
            return parent::query();
        if (Auth()->user()->moonshine_user_role_id === 2)
            // Admin видит только админов и водителей
            return parent::query()
                ->where('moonshine_user_role_id', '>=', 2);
        // Остальные видят только водителей
        return
            parent::query()
            ->where('moonshine_user_role_id', 3);
    }

    public function fields(): array
    {
        return [
            Block::make([
                Tabs::make([
                    Tab::make(__('moonshine::ui.resource.main_information'), [
                        ID::make()
                            ->sortable()
                            ->showOnExport()
                            ->hideOnIndex(),

                        Text::make(__('moonshine::ui.resource.name'), 'name')
                            ->required()
                            ->sortable()
                            ->showOnExport(),

                        BelongsTo::make(
                            __('moonshine::ui.resource.role'),
                            'moonshineUserRole',
                            static fn (MoonshineUserRole $model) => $model->name,
                            new MoonShineUserRoleResource(),
                        )
                            ->sortable()
                            ->badge('purple'),

                        // Image::make(__('moonshine::ui.resource.avatar'), 'avatar')
                        //     ->showOnExport()
                        //     ->disk(config('moonshine.disk', 'public'))
                        //     ->dir('moonshine_users')
                        //     ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif']),

                        Date::make(__('moonshine::ui.resource.created_at'), 'created_at')
                            ->format("d.m.Y")
                            ->default(now()->toDateTimeString())
                            ->sortable()
                            ->hideOnForm()
                            ->hideOnIndex()
                            ->showOnExport(),

                        StackFields::make('email/phone')->fields([
                            Email::make(__('moonshine::ui.resource.email'), 'email')
                                ->sortable()
                                ->showOnExport()
                                ->required(),
                            Phone::make('phone')
                                //->mask('+7(999) 999-99-99')
                                ->translatable('moonshine::ui.resource')
                                ->sortable()
                                ->showOnExport()
                                ->required(),
                        ])->translatable('moonshine::ui.resource'),
                        Text::make('e1_card')
                            ->sortable()
                            ->showOnExport()
                            ->translatable('moonshine::ui.resource'),
                    ]),

                    Tab::make(__('moonshine::ui.resource.password'), [
                        Heading::make('Change password'),

                        Password::make(__('moonshine::ui.resource.password'), 'password')
                            ->customAttributes(['autocomplete' => 'new-password'])
                            ->hideOnIndex()
                            ->eye(),

                        PasswordRepeat::make(__('moonshine::ui.resource.repeat_password'), 'password_repeat')
                            ->customAttributes(['autocomplete' => 'confirm-password'])
                            ->hideOnIndex()
                            ->eye(),
                    ]),
                ]),
            ]),
        ];
    }

    /**
     * @return array{name: string, moonshine_user_role_id: string, email: mixed[], password: string}
     */
    public function rules($item): array
    {
        return [
            'name' => 'required',
            'moonshine_user_role_id' => 'required',
            'email' => [
                'sometimes',
                'bail',
                'required',
                'email',
                Rule::unique('moonshine_users')->ignoreModel($item),
            ],
            'phone' => [
                'sometimes',
                'bail',
                'required',
                Rule::unique('moonshine_users')->ignoreModel($item),
            ],
            'password' => $item->exists
                ? 'sometimes|nullable|min:6|required_with:password_repeat|same:password_repeat'
                : 'required|min:6|required_with:password_repeat|same:password_repeat',
        ];
    }

    public function getActiveActions(): array
    {
        return ['create', 'update', 'delete'];
    }

    public function search(): array
    {
        return [
            'email',
            'phone',
            'name',
        ];
    }
}

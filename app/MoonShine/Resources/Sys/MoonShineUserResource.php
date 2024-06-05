<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Sys;

use App\Models\Profit;
use MoonShine\Attributes\Icon;
use Illuminate\Validation\Rule;
use App\Models\Sys\MoonshineUser;
use Illuminate\Support\Facades\Auth;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use App\MoonShine\Resources\MainResource;
use Illuminate\Database\Eloquent\Builder;
use App\MoonShine\Pages\Sys\User\UserFormPage;
use App\MoonShine\Pages\Sys\User\UserIndexPage;

/**
 * @extends ModelResource<MoonshineUser>
 */
#[Icon('heroicons.outline.users')]
class MoonShineUserResource extends MainResource
{
    // Модель данных
    public string $model = MoonshineUser::class;

    // Поле сортировки по умолчанию
    protected string $sortColumn = 'name';

    // Тип сортировки по умолчанию
    protected string $sortDirection = 'ASC';

    // Поле для отображения значений в связях и хлебных крошках
    public string $column = 'name';

    public array $with = ['moonshineUserRole'];

    /**
     * getAlias
     * Устанавливает алиас для ресурса.
     * @return string
     */
    public function getAlias(): ?string
    {
        return __('moonshine::system.user.resource_user');
    }

    /**
     * title
     * Устанавливает заголовок для ресурса.
     * @return string
     */
    public function title(): string
    {
        return __('moonshine::system.user.users');
    }

    public function query(): Builder
    {
        if (Auth()->user()->moonshine_user_role_id == 1)
            // SuperAdmin видит всех
            return parent::query();
        if (Auth()->user()->moonshine_user_role_id == 2)
            // Admin видит только админов и водителей
            return parent::query()
                ->where('moonshine_user_role_id', '>=', 2);
        // Остальные видят только водителей
        return
            parent::query()
            ->where('moonshine_user_role_id', 3);
    }

    /**
     * pages
     *
     * @return array
     */
    public function pages(): array
    {
        return [
            UserIndexPage::make($this->title()),
            UserFormPage::make(
                $this->getItemID()
                    ? __('moonshine::ui.edit')
                    : __('moonshine::ui.add')
            ),
        ];
    }

    /**
     * rules
     * Правила проверки вводимых данных
     * @param  mixed $item
     * @return array
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
            // 'phone' => [
            //     'sometimes',
            //     'bail',
            //     'required',
            //     Rule::unique('moonshine_users')->ignoreModel($item),
            // ],
            'password' => $item->exists
                ? 'sometimes|nullable|min:6|required_with:password_repeat|same:password_repeat'
                : 'required|min:6|required_with:password_repeat|same:password_repeat',
        ];
    }

    /**
     * search
     * Поля для поиска
     * @return array
     */
    public function search(): array
    {
        return [
            'name',
        ];
    }

    /**
     * afterCreated
     *
     * @param  mixed $item
     * @return Model
     */
    protected function afterCreated(Model $item): Model
    {
        $profit = new Profit();
        $profit->owner_id = Auth::user()->id;
        $profit->title = 'Старт';
        $profit->comment = 'Начальная загрузка';
        $item->profits()->save($profit);
        return $item;
    }
}

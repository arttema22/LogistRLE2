<?php

declare(strict_types=1);

namespace App\MoonShine\Controllers;

use App\Models\Profit;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use MoonShine\MoonShineRequest;
use App\Models\Sys\MoonshineUser;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use MoonShine\Http\Controllers\MoonShineController;

final class FormNewUserController extends MoonShineController
{
    public function __invoke(MoonShineRequest $request): Response
    {
        $validated = $request->validate([
            'surname' => ['required'],
            'name' => ['required'],
            'role' => ['required'],
            'email' => [
                'sometimes', 'bail', 'required', 'email',
                // Rule::unique('moonshine_users')->ignoreModel($item),
            ],
            'password' => ['required'],
            // 'password' => $item->exists
            //     ? 'sometimes|nullable|min:6|required_with:password_repeat|same:password_repeat'
            //     : 'required|min:6|required_with:password_repeat|same:password_repeat',
        ]);

        $user = new MoonshineUser();
        $user->moonshine_user_role_id = $request->role;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->name = Str::title($request->surname) . ' '
            . Str::upper(Str::limit($request->name, 1, '.')) .
            Str::upper(Str::limit($request->patronymic, 1, '.'));
        $user->save();

        $profit = new Profit();
        $profit->owner_id = Auth::user()->id;
        $profit->saldo_start = $request->saldo_start;
        $profit->comment = 'Начальная загрузка';
        $user->profits()->save($profit);



        $this->toast('new_user_added', 'success');

        return back();
    }
}

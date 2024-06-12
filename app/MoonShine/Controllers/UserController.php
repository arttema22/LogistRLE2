<?php

declare(strict_types=1);

namespace App\MoonShine\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileFormRequest;
use Symfony\Component\HttpFoundation\Response;
use MoonShine\Http\Controllers\MoonShineController;

final class UserController extends MoonShineController
{
    /**
     * storeProfile
     *
     * @param  mixed $request
     * @return Response
     */
    public function storeProfile(ProfileFormRequest $request): Response
    {
        $data = $request->validated();

        $profileData = [
            config('moonshine.auth.fields.surname', 'surname') => e($data['surname']),
            config('moonshine.auth.fields.name', 'name') => e($data['name']),
            config('moonshine.auth.fields.patronymic', 'patronymic') => e($data['patronymic']),
        ];

        if (isset($data['phone']) && filled($data['phone'])) {
            $profileData[config('moonshine.auth.fields.phone', 'phone')] = e($data['phone']);
        } else {
            $profileData[config('moonshine.auth.fields.phone', 'phone')] = null;
        }

        if (isset($data['e1_card']) && filled($data['e1_card'])) {
            $profileData[config('moonshine.auth.fields.e1_card', 'e1_card')] = e($data['e1_card']);
        } else {
            $profileData[config('moonshine.auth.fields.e1_card', 'e1_card')] = null;
        }

        $userData = [
            'name' => Str::title($profileData['surname']) . ' '
                . Str::upper(Str::limit($profileData['name'], 1, '.')) .
                Str::upper(Str::limit($profileData['patronymic'], 1, '.')),
            config('moonshine.auth.fields.email', 'email') => e($data['email']),
        ];

        if (isset($data['password']) && filled($data['password'])) {
            $userData[config('moonshine.auth.fields.password', 'password')] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $request->user()->profile()->update($profileData);
        $request->user()->update($userData);

        $this->toast(__('moonshine::ui.saved'), 'success');

        return back();
    }
}

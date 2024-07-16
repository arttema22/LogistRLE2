<?php

declare(strict_types=1);

namespace App\MoonShine\Controllers;

use App\Http\Requests\NewUserFormRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileFormRequest;
use App\Models\Sys\MoonshineUser;
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

    /**
     * store
     *
     * @param  mixed $request
     * @return Response
     */
    public function store(NewUserFormRequest $request): Response
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

        if (isset($data['1c_ref_key']) && filled($data['1c_ref_key'])) {
            $profileData[config('moonshine.auth.fields.1c_ref_key', '1c_ref_key')] = e($data['1c_ref_key']);
        } else {
            $profileData[config('moonshine.auth.fields.1c_ref_key', '1c_ref_key')] = null;
        }

        if (isset($data['1c_contract']) && filled($data['1c_contract'])) {
            $profileData[config('moonshine.auth.fields.1c_contract', '1c_contract')] = e($data['1c_contract']);
        } else {
            $profileData[config('moonshine.auth.fields.1c_contract', '1c_contract')] = null;
        }
        // dd($profileData);
        $userData = [
            'moonshine_user_role_id' => e($data['role']),

            'name' => Str::title($profileData['surname']) . ' '
                . Str::upper(Str::limit($profileData['name'], 1, '.')) .
                Str::upper(Str::limit($profileData['patronymic'], 1, '.')),

            config('moonshine.auth.fields.email', 'email') => e($data['email']),

            config('moonshine.auth.fields.password', 'password') => Hash::make($data['password']),
        ];

        $profitData = ['owner_id' => Auth()->id()];
        if (isset($data['saldo_start']) && filled($data['saldo_start'])) {
            $profitData[config('moonshine.auth.fields.saldo_start', 'saldo_start')] = e($data['saldo_start']);
        } else {
            $profitData[config('moonshine.auth.fields.saldo_start', 'saldo_start')] = 0;
        }

        $newUser = new MoonshineUser($userData);
        $newUser->save();
        $newUser->profile()->create($profileData)->save();
        $newUser->profits()->create($profitData)->save();

        $this->toast(__('moonshine::ui.saved'), 'success');
        return back();
    }
}

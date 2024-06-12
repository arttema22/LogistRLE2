<?php

namespace App\Http\Requests;

use MoonShine\MoonShineAuth;
use App\Models\Sys\UserProfil;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ProfileFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return MoonShineAuth::guard()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'surname' => 'required',
            'name' => 'required',
            'patronymic' => 'sometimes|nullable',
            'phone' =>
            [
                'sometimes', 'nullable',
                Rule::unique(
                    'user_profils',
                    'phone'
                )->ignore(Auth::user()->profile->id),
            ],
            'e1_card' => [
                'sometimes', 'nullable',
                Rule::unique(
                    'user_profils',
                    'e1_card'
                )->ignore(Auth::user()->profile->id),
            ],
            'email' => [
                'required',
                Rule::unique(
                    MoonShineAuth::model()?->getTable(),
                    config('moonshine.auth.fields.email', 'email')
                )->ignore(MoonShineAuth::guard()->id()),
            ],
            'password' => 'sometimes|nullable|min:6|required_with:password_repeat|same:password_repeat',
        ];
    }
}

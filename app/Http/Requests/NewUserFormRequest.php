<?php

namespace App\Http\Requests;

use MoonShine\MoonShineAuth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class NewUserFormRequest extends FormRequest
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
            'patronymic' => 'nullable',
            'role' => 'required',
            'password' => 'required|min:6|required_with:password_repeat|same:password_repeat',
            'email' => [
                'required',
                Rule::unique(
                    MoonShineAuth::model()?->getTable(),
                    config('moonshine.auth.fields.email', 'email')
                ),
            ],
            'phone' =>
            [
                'nullable',
                Rule::unique('user_profils', 'phone'),
            ],
            'e1_card' => [
                'nullable',
                Rule::unique('user_profils', 'e1_card'),
            ],
            'saldo_start' => 'nullable',
        ];
    }
}

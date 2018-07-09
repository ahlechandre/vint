<?php

namespace Modules\User\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserPasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'required|string|min:6|max:24|confirmed',
            'password_confirmation' => 'required',
        ];
    }

    /**
     *
     * @return array
     */
    public function messages()
    {
        return [
            'unique' => 'O :attribute já está em uso',
            'required' => 'O campo :attribute é obrigatório',
            'min' => 'O campo :attribute requer, no mínimo, :min caracteres',
            'max' => 'O campo :attribute requer, no máximo, :max caracteres',
        ];
    }

    /**
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'nome',
            'email' => 'e-mail',
            'password' => 'senha',
            'role_id' => 'papel',
        ];
    }

    /**
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}

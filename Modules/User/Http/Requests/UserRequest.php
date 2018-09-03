<?php

namespace Modules\User\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\User\Entities\User;
use Modules\System\Entities\Role;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $isUpdate = $this->method() === 'PUT';

        return [
            'name' => 'required|string|min:2',
            'username' => [
                'required',
                'regex:/' . __('patterns.username') . '/',
                $isUpdate ?
                   Rule::unique('users')
                       ->ignore($this->user) :
                   'unique:users'
            ],
            'email' => [
                'required',
                'email',
                $isUpdate ?
                Rule::unique('users')
                    ->ignore($this->user) :
                'unique:users'
            ],
            'password' => [
                $isUpdate ? 'nullable' : 'required',
                'string',
                'min:6',
                'max:24'
            ],
            'user_type_id' => 'required|integer',
        ];
    }

    /**
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => __('attrs.name'),
            'email' => __('attrs.email'),
            'password' => __('attrs.password'),
            'username' => __('attrs.username'),
            'user_type_id' => __('resources.user_type'),
        ];
    }

    /**
     *
     * @return array
     */
    public function sanitize()
    {
        $inputs = $this->all();
        $isUpdate = $this->method() === 'PUT';
        $inputs['is_active'] = sanitize_bool_input($inputs, 'is_active');
        
        // Ao atualizar, remove o campo de senha pois
        // ele é "fillable". A atualização de senha deve ser feita
        // por outra requisição.
        if ($isUpdate) {
            unset($inputs['password']);
        }

        return $inputs;
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

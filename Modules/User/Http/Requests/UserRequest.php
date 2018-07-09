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
        $default = [
            'name' => 'required|string|min:2',
            'identification_number' => [
                'required',
                'digits:11',
                $isUpdate ?
                    Rule::unique('users')->ignore($this->user) :
                    'unique:users'
            ],
            'email' => 'nullable|email',
            'password' => [
                $isUpdate ?
                    'nullable' :
                    'required',
                'string',
                'min:6',
                'max:24'
            ],
            'role_id' => 'required|integer',
        ];

        return array_merge($default);
    }

    /**
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => __('validations.required'),
            'unique' => __('validations.unique'),
            'digits' => __('validations.digits'),
            'email' => __('validations.email'),
            'min' => __('validations.strings.min'),
            'max' => __('validations.strings.max'),
            'integer' => __('validations.integer'),
            'numeric' => __('validations.numeric'),
            'array' => __('validations.array'),
        ];
    }

    /**
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => __('columns.name'),
            'email' => __('columns.email'),
            'identification_number' => __('columns.user.identification_number'),
            'password' => __('columns.password'),
            'role_id' => __('resources.role'),
        ];
    }

    /**
     *
     * @return array
     */
    public function sanitize()
    {
        $inputs = $this->all();
        $inputs['is_active'] = sanitize_is_active($inputs);
        
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

<?php

namespace Modules\Group\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
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
            'name' => [
                'required',
                $isUpdate ?
                   Rule::unique('groups')
                       ->ignore($this->group) :
                   'unique:groups'
            ],
            'description' => 'nullable|string',
        ];
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
            'description' => __('attrs.description'),
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

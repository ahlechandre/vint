<?php

namespace Modules\System\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|min:2',
            'abilities' => 'nullable|array',
            'abilities.*' => 'integer',
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
            'string' => __('validations.string'),
            'max' => __('validations.strings.max'),
            'min' => __('validations.strings.min'),
            'array' => __('validations.array'),
            'integer' => __('validations.integer'),
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
            'description' => __('columns.description'),
            'abilities' => __('resources.abilities'),
            'abilities.*' => __('resources.ability'),
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
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}

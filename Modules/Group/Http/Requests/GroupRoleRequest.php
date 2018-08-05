<?php

namespace Modules\Group\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupRoleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'permissions' => 'nullable|array',
            'permissions.*' => 'integer',
        ];
    }

    /**
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }

    /**
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'permissions' => __('resources.permissions'),
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

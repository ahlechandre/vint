<?php

namespace Modules\Group\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoordinatorRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $isUpdate = $this->method() === 'PUT';

        if ($isUpdate) {
            return [];
        }

        return [
            'coordinator_user_id' => 'required|integer',
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
            'format' => __('validations.format'),
            'after' => __('validations.after'),
        ];
    }

    /**
     *
     * @return array
     */
    public function attributes()
    {
        return [];
    }

    /**
     *
     * @return array
     */
    public function sanitize()
    {
        $inputs = $this->all();
        $inputs['is_vice'] = isset($inputs['is_vice']) && $inputs['is_vice'];
        
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

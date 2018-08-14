<?php

namespace Modules\Project\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectStudentRequest extends FormRequest
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
            'student_user_id' => 'required|integer',
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
        $inputs['is_scholarship'] = isset($inputs['is_scholarship']) && $inputs['is_scholarship'];
        
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

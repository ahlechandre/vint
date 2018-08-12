<?php

namespace Modules\Project\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
                'string',
                $isUpdate ?
                   Rule::unique('projects')
                       ->ignore($this->project) :
                   'unique:projects'
            ],
            'coordinator_user_id' => 'required|integer',
            'program_id' => 'nullable|integer',
            'leader_user_id' => 'nullable|integer',
            'supporter_user_id' => 'nullable|integer',
            'start_on' => 'required|date|before_or_equal:today',
            'finish_on' => 'nullable|date|after:start_on',
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
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}

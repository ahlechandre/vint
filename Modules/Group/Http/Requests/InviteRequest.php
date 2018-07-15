<?php

namespace Modules\Group\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InviteRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'expires_at' => 'required|after:today|date_format:Y-m-d'
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
        return [
            'expires_at' => __('attrs.expires_at'),
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

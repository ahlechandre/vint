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
            'required' => __('validations.required'),
            'min' => __('validations.min'),
            'max' => __('validations.max'),
            'confirmed' => __('validations.confirmed'),
        ];
    }

    /**
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'password' => __('attrs.password_new'),
            'password_confirmation' => __('attrs.password_confirmation')
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

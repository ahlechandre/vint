<?php

namespace Modules\Product\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'title' => [
                'required',
                $isUpdate ?
                   Rule::unique('products')
                       ->ignore($this->product) :
                   'unique:products'
            ],
            'description' => 'required|string',
            'url' => 'nullable|string',
            'projects' => 'required|array',
            'projects.*' => 'integer',
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

<?php

namespace Modules\Member\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Member\Entities\Role;

class MemberRoleRequest extends FormRequest
{
    /**
     * @var \Modules\Member\Entities\Role
     */
    protected $role;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Acessa o papel.
        $this->role = Role::findOrFail(
            $this->route('role')
        );

        // Servidor.
        if ($this->role->isServant()) {
            $servant = [
                'servant.siape' => [
                    'required',
                    'regex:/' . __('patterns.siape') . '/',
                    Rule::unique('servants', 'siape')
                        ->ignore($this->member, 'member_user_id')
                ]
            ];

            return $servant;
        }

        // Aluno.
        if ($this->role->isStudent()) {
            $student = [
                'student.rga' => [
                    'required',
                    'regex:/' . __('patterns.rga') . '/',
                    Rule::unique('students', 'rga')
                        ->ignore($this->member, 'member_user_id')
                ]
            ];
         
            return $student;
        }

        // Colaborador.
        return []; 
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

        if ($this->role->isServant()) {
            $inputs['servant']['is_professor'] = isset($inputs['servant']['is_professor']) && $inputs['servant']['is_professor'];
        } 
        
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

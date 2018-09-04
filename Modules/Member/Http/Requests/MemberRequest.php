<?php

namespace Modules\Member\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Member\Entities\Role;

class MemberRequest extends FormRequest
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
        // Acessa o papel do member.
        $this->role = Role::findOrFail(
            $this->input('role_id')
        );
        $member = [
            'cpf' => [
                'required',
                'regex:/' . __('patterns.cpf') . '/',
                'digits:11',
                Rule::unique('members')
                    ->ignore($this->member, 'user_id')
            ],
            'description' => 'nullable|string'
        ];

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

            return array_merge($member, $servant);
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
         
            return array_merge($member, $student);
        }

        // Colaborador.
        return $member;        
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
            $inputs['servant']['is_professor'] = sanitize_bool_input($inputs['servant'], 'is_professor');
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

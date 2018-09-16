<?php

namespace Modules\Member\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Member\Entities\Role;

class RegisterRequest extends FormRequest
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
        $user = [
            'name' => 'required|string|min:2',
            'username' => [
                'required',
                'regex:/' . __('patterns.username') . '/',
                'unique:users'
            ],
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:24',
        ];
        $member = [
            'member.cpf' => [
                'required',
                'regex:/' . __('patterns.cpf') . '/',
                'digits:11',
                'unique:members,cpf'
            ],
            'member.role_id' => 'required|integer',
            'member.description' => 'nullable|string',
        ];
        // Tipo do novo membro.
        $this->role = Role::findOrFail(
            $this->input('member.role_id')
        );

        // Verifica se é um novo servidor.
        if ($this->role->isServant()) {
            $servant = [
                'servant.siape' => [
                    'required',
                    'regex:/' . __('patterns.siape') . '/',
                    'unique:servants,siape'
                ]
            ];
         
            return array_merge($user, $member, $servant);
        }

        // Verifica se é um novo aluno.
        if ($this->role->isStudent()) {
            $student = [
                'student.rga' => [
                    'required',
                    'regex:/' . __('patterns.rga') . '/',
                    'unique:students,rga'
                ]
            ];
         
            return array_merge($user, $member, $student);
        }

        // Novo colaborador.
        return array_merge($user, $member);
    }

    /**
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'required' => __('validations.required'),
            'unique' => __('validations.unique'),
            'regex' => __('validations.regex'),
            'digits' => __('validations.digits'),
            'email' => __('validations.email'),
            'min' => __('validations.strings.min'),
            'max' => __('validations.strings.max'),
            'integer' => __('validations.integer'),
            'numeric' => __('validations.numeric'),
            'array' => __('validations.array'),
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

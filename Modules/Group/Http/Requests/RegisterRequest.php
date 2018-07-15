<?php

namespace Modules\Group\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Group\Entities\MemberType;
use Modules\Group\Entities\Invite;

class RegisterRequest extends FormRequest
{
    /**
     * @var \Modules\Group\Entities\MemberType
     */
    protected $memberType;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = [
            'invite_token' => 'required|size:' . Invite::TOKEN_LENGTH,
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
            'member.member_type_id' => 'required|integer',
            'member.description' => 'nullable|string'
        ];
        // Tipo do novo membro.
        $this->memberType = MemberType::findOrFail(
            $this->input('member.member_type_id')
        );

        // Verifica se é um novo servidor.
        if ($this->memberType->isServant()) {
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
        if ($this->memberType->isStudent()) {
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
        
        if ($this->memberType->isServant()) {
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

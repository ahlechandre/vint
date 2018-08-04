{{-- Inputs escondidos --}}
<input type="hidden" name="invite_token" value="{{ $invite->token }}">
<input type="hidden" name="member[role_id]" value="{{ $role->id }}">

@layoutGridInner
    {{-- Nome --}}
    @cell([
        'when' => ['d' => 6, 't' => 8, 'p' => 4]
    ])
        @textfield([
            'label' => __('attrs.name'),
            'helperText' => $validations['name'] ?? null,
            'attrs' => [
                'type' => 'text',
                'name' => 'name',
                'id' => 'textfield-user-name',
                'required' => '',
                'value' => $name
            ],
        ]) @endtextfield
    @endcell

    {{-- Nome de usuário --}}
    @cell([
        'when' => ['d' => 6, 't' => 8, 'p' => 4]
    ])
        @textfield([
            'label' => __('attrs.username'),
            'helperText' => $validations['username'] ?? [
                'isPersistent' => true,
                'isValidation' => false,
                'message' => __('messages.helpers.username'),
            ],
            'attrs' => [
                'type' => 'text',
                'name' => 'username',
                'required' => '',
                'pattern' => __('patterns.username'),
                'id' => 'textfield-user-username',
                'value' => $username
            ]
        ]) @endtextfield
    @endcell

    {{-- E-mail --}}
    @cell([
        'when' => ['d' => 6, 't' => 8, 'p' => 4]
    ])
        @textfield([
            'label' => __('attrs.email'),
            'helperText' => $validations['email'] ?? null,
            'attrs' => [
                'type' => 'email',
                'name' => 'email',
                'required' => '',
                'id' => 'textfield-user-email',
                'value' => $email,
            ]
        ]) @endtextfield
    @endcell    

    {{-- Senha --}}
    @cell([
        'when' => ['d' => 6, 't' => 8, 'p' => 4]
    ])
        @textfield([
            'label' => __('attrs.password'),
            'helperText' => $validations['password'] ?? [
                'isPersistent' => true,
                'isValidation' => false,
                'message' => __('messages.helpers.password'),
            ],
            'attrs' => [
                'type' => 'password',
                'name' => 'password',
                'id' => 'textfield-user-password',
                'required' => '',
                'minlength' => 6,
            ]    
        ]) @endtextfield
    @endcell

    {{-- CPF --}}
    @cell([
        'when' => ['d' => 12, 't' => 8, 'p' => 4]
    ])
        @textfield([
            'label' => __('attrs.cpf'),
            'helperText' => $validations['member.cpf'] ?? [
                'isPersistent' => true,
                'isValidation' => false,
                'message' => __('messages.helpers.cpf'),
            ],
            'attrs' => [
                'type' => 'text',
                'name' => 'member[cpf]',
                'required' => '',
                'minlength' => '11',
                'maxlength' => '11',
                'pattern' => __('patterns.cpf'),
                'id' => 'textfield-user-member-cpf',
                'value' => $cpf
            ]
        ]) @endtextfield
    @endcell

    {{-- Descrição --}}
    @cell([
        'when' => ['d' => 12, 't' => 8, 'p' => 4]
    ])
        @textarea([
            'label' => __('attrs.description'),
            'helperText' => $validations['member.description'] ?? [
                'isPersistent' => true,
                'isValidation' => false,
                'message' => __('messages.helpers.member.description'),
            ],
            'attrs' => [
                'name' => 'member[description]',
                'cols' => 100,
                'id' => 'textfield-user-member-description',
                'value' => $description
            ]
        ]) @endtextarea
    @endcell

    {{-- Campos que variam de acordo com o papel --}}
    @if ($role->isServant())
        {{-- SIAPE --}}
        @cell([
            'when' => ['d' => 12, 't' => 8, 'p' => 4]
        ])
            @textfield([
                'label' => __('attrs.siape'),
                'helperText' => $validations['servant.siape'] ?? [
                    'isPersistent' => true,
                    'isValidation' => false,
                    'message' => __('messages.helpers.siape'),
                ],
                'attrs' => [
                    'type' => 'text',
                    'name' => 'servant[siape]',
                    'required' => '',
                    'pattern' => __('patterns.siape'),
                    'id' => 'textfield-user-servant-siape',
                    'value' => $siape
                ]
            ]) @endtextfield
        @endcell

        {{-- É professor --}}
        @cell([
            'when' => ['d' => 12, 't' => 8, 'p' => 4]
        ])
            @checkbox([
                'label' => __('attrs.is_professor'),
                'attrs' => [
                    'type' => 'text',
                    'name' => 'servant[is_professor]',
                    'id' => 'textfield-user-servant-is-professor',
                    'checked' => $isProfessor
                ]
            ]) @endcheckbox
        @endcell
    @elseif ($role->isStudent())
        {{-- RGA --}}
        @cell([
            'when' => ['d' => 12, 't' => 8, 'p' => 4]
        ])
            @textfield([
                'label' => __('attrs.rga'),
                'helperText' => $validations['student.rga'] ?? [
                    'isPersistent' => true,
                    'isValidation' => false,
                    'message' => __('messages.helpers.rga'),
                ],
                'attrs' => [
                    'type' => 'text',
                    'name' => 'student[rga]',
                    'required' => '',
                    'pattern' => __('patterns.rga'),
                    'id' => 'textfield-user-student-rga',
                    'value' => $rga
                ]
            ]) @endtextfield
        @endcell
    @endif
@endlayoutGridInner
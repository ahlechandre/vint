@gridInner
    {{-- Nome --}}
    @cell([
        'when' => ['d' => 8, 't' => 4, 'p' => 4]
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

    {{-- Tipo de usuário --}}
    @cell([
        'when' => ['d' => 4, 't' => 4, 'p' => 4]
    ])
        {{-- Se o usuário for membro, adiciona um campo escondido
        para indicar o seu tipo apenas para passar na requisição.
        Independente do tipo indicado aqui, a validação está no repositório. --}}
        @if ($user->isMember())
            <input type="hidden" name="user_type_id" value="{{ $user->user_type_id }}">
        @endif

        @select([
            'label' => __('resources.user_type'),
            'helperText' => $validations['user_type_id'] ?? null,
            'attrs' => [
                'name' => 'user_type_id',
                'id' => 'select-user-type',
                'required' => '',
                'disabled' => $user->isMember()
            ],
            'options' => $userTypes->map(function ($userType) use ($userTypeId) {
                return [
                    'text' => $userType->name,
                    'attrs' => [
                        'value' => $userType->id,
                        'selected' => $userTypeId == $userType->id,
                    ],
                ];
            })->prepend([
                'text' => '',
                'attrs' => [
                    'value' => '',
                    'disabled' => '',
                    'selected' => '',
                ],
            ])
        ]) @endselect
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
    @if (!$isUpdate)
        @cell([
            'when' => ['d' => 12, 't' => 8, 'p' => 4]
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
    
    @endif

    {{-- Está ativo --}}
    @cell([
        'when' => ['d' => 12, 't' => 8, 'p' => 4]
    ])
        @materialSwitch([
            'label' => __('attrs.is_active_switch'),
            'attrs' => [
                'name' => 'is_active',
                'id' => 'textfield-user-is-active',
                'checked' => $isActive ? true : false,
            ]    
        ]) @endmaterialSwitch    
    @endcell
@endgridInner
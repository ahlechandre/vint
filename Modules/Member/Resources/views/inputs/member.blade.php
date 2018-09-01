@layoutGridInner
    {{-- Input para o papel --}}
    <input type="hidden" name="role_id" value="{{ $member->role_id }}">

    {{-- Papel --}}
    @cell([
        'when' => ['d' => 12, 't' => 8, 'p' => 4],
        'modifiers' => ['mdc-layout-grid--align-right']
    ])
        @menuAnchor
            {{-- Button --}}
            @button([
                'text' => 'Alternar papel',
                'icon' => 'keyboard_arrow_down',
                'attrs' => [
                    'id' => 'menu-member-roles',
                    'type' => 'button'
                ],
            ]) @endbutton

            {{-- Menu --}}
            @menu
                @foreach($roles as $role)
                    @menuItem([
                        'text' => $role->name,
                        'attrs' => [
                            'id' => "dialog-activation-member-role-{$role->slug}",
                            'aria-disabled' => $role->id === $member->role_id ? 'true' : 'false',
                            'tab-index' => $role->id === $member->role_id ? '-1' : '0'
                        ]
                    ]) @endmenuItem
                @endforeach
            @endmenu
        @endmenuAnchor
    @endcell

    {{-- CPF --}}
    @cell([
        'when' => ['d' => 12, 't' => 8, 'p' => 4]
    ])
        @textfield([
            'label' => __('attrs.cpf'),
            'helperText' => $validations['cpf'] ?? [
                'isPersistent' => true,
                'isValidation' => false,
                'message' => __('messages.helpers.cpf'),
            ],
            'attrs' => [
                'type' => 'text',
                'name' => 'cpf',
                'required' => '',
                'minlength' => '11',
                'maxlength' => '11',
                'pattern' => __('patterns.cpf'),
                'id' => 'textfield-member-cpf',
                'value' => $member->cpf
            ]
        ]) @endtextfield
    @endcell

    {{-- Descrição --}}
    @cell([
        'when' => ['d' => 12, 't' => 8, 'p' => 4]
    ])
        @textarea([
            'label' => __('attrs.description'),
            'helperText' => $validations['description'] ?? [
                'isPersistent' => true,
                'isValidation' => false,
                'message' => __('messages.helpers.member.description'),
            ],
            'attrs' => [
                'name' => 'description',
                'cols' => 100,
                'id' => 'textfield-member-description',
                'value' => $member->description
            ]
        ]) @endtextarea
    @endcell

    {{-- Campos que variam de acordo com o papel --}}
    @if ($member->isServant())
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
                    'id' => 'textfield-member-servant-siape',
                    'value' => $member->servant->siape
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
                    'id' => 'textfield-member-servant-is-professor',
                    'checked' => $member->servant
                        ->is_professor ? true : false
                ]
            ]) @endcheckbox
        @endcell
    @elseif ($member->isStudent())
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
                    'id' => 'textfield-member-student-rga',
                    'value' => $member->student->rga
                ]
            ]) @endtextfield
        @endcell
    @endif
@endlayoutGridInner

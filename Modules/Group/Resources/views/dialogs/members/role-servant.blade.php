{{-- Diálogo --}}
@dialog([
    'activation' => 'dialog-activation-member-role-servant',
    'cancel' => [
        'text' => __('actions.cancel'),
        'attrs' => [
            'type' => 'button' 
        ],
    ],
    'accept' => [
        'text' => __('actions.update'),
        'attrs' => [
            'type' => 'submit'
        ],
    ],
    'attrs' => [
        'id' => 'dialog-member-role-servant'
    ],
    'title' => __('messages.members.dialog.role_servant_title')
])
    {{ __('messages.members.dialog.role_servant_body') }}
    {{-- SIAPE --}}
    @cell([
        'when' => ['d' => 12, 't' => 8, 'p' => 4]
    ])
        @textfield([
            'label' => __('attrs.siape'),
            'helperText' => [
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
                'id' => 'textfield-member-servant-is-professor',
                'checked' => $isProfessor ? true : false
            ]
        ]) @endcheckbox
    @endcell        
@enddialog

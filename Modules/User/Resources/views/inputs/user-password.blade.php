@gridInner
    {{-- Nova Senha --}}
    @cell([
        'when' => ['d' => 6, 't' => 8, 'p' => 4]
    ])
        @textfield([
            'label' => __('attrs.password_new'),
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

    {{-- Confirmação Nova Senha --}}
    @cell([
        'when' => ['d' => 6, 't' => 8, 'p' => 4]
    ])
        @textfield([
            'label' => __('attrs.password_confirmation'),
            'helperText' => $validations['password_confirmation'] ?? null,
            'attrs' => [
                'type' => 'password',
                'name' => 'password_confirmation',
                'id' => 'textfield-user-password-confirmation',
                'required' => '',
                'minlength' => 6,
            ]
        ]) @endtextfield
    @endcell    
@endgridInner
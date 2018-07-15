@layoutGridInner
    {{-- E-mail --}}
    @cell([
        'when' => ['d' => 12, 't' => 8, 'p' => 4]
    ])
        @textfield([
            'label' => __('attrs.email'),
            'attrs' => [
                'type' => 'email',
                'name' => 'email',
                'required' => '',
                'id' => 'textfield-login-email',
            ],
        ]) @endtextfield
    @endcell

    {{-- Senha --}}
    @cell([
        'when' => ['d' => 12, 't' => 8, 'p' => 4]
    ])
        @textfield([
            'label' => __('attrs.password'),
            'attrs' => [
                'type' => 'password',
                'name' => 'password',
                'required' => '',
                'id' => 'textfield-login-password',
            ],
        ]) @endtextfield    
    @endcell

    {{-- Submit --}}
    @cell([
        'when' => ['d' => 12, 't' => 8, 'p' => 4],
        'modifiers' => ['mdc-layout-grid--align-right']
    ])
        @button([
            'text' => __('actions.login'),
            'modifiers' => ['mdc-button--unelevated'],
            'attrs' => [
                'type' => 'submit'
            ],
        ]) @endbutton
    @endcell
@endlayoutGridInner
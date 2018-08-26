@gridInner
    @cell
        @textfield([
            'label' => __('attrs.email'),
            'attrs' => [
                'id' => 'textfield-login-email',
                'name' => 'email',
                'type' => 'email',
                'required' => '',
                'autocomplete' => 'off',
            ],
            'helperText' => [
                'isPersistent' => true,
                'isValidation' => $errors->get('auth')[0] ?? false,
                'text' => $errors->get('auth')[0] ?? null,
            ]
        ]) @endtextfield
    @endcell

    @cell
        @textfield([
            'label' => __('attrs.password'),
            'attrs' => [
                'id' => 'textfield-login-password',
                'name' => 'password',
                'type' => 'password',
                'required' => '',
            ],
        ]) @endtextfield
    @endcell 

    {{-- Cadastre-se --}}
    @cell([
        'when' => ['d' => 6, 't' => 4, 'p' => 2]
    ])
        @button([
            'isLink' => true,
            'classes' => ['mdc-button--outlined'],
            'text' => __('actions.signup'),
            'attrs' => [
                'href' => url('register')
            ]
        ]) @endbutton
    @endcell

    {{-- Entrar --}}
    @cell([
        'when' => ['d' => 6, 't' => 4, 'p' => 2],
        'classes' => ['mdc-layout-grid--align-right']
    ])
        @button([
            'text' => __('actions.signin'),
            'classes' => ['mdc-button--unelevated'],
            'attrs' => [
                'type' => 'submit'
            ]
        ]) @endbutton
    @endcell
@endgridInner
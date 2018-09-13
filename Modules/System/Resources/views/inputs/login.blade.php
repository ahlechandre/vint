@gridInner
    @cell
        @textfield([
            'label' => __('attrs.email'),
            'attrs' => [
                'id' => 'textfield-login-email',
                'name' => 'email',
                'type' => 'email',
                'required' => '',
            ],
            'helperText' => isset($errors->get('auth')[0]) ? [
                'isPersistent' => true,
                'isValidation' => true,
                'text' => $errors->get('auth')[0],
            ] : null
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

    {{-- Espaçamento --}}
    @cell @endcell

    {{-- Cadastre-se --}}
    @cell([
        'when' => ['d' => 6, 't' => 4, 'p' => 2]
    ])
        @button([
            'isLink' => true,
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
            'classes' => ['mdc-button--outlined'],
            'icon' => __('icons.forward'),
            'attrs' => [
                'type' => 'submit'
            ]
        ]) @endbutton
    @endcell
@endgridInner
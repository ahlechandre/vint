@extends('layouts.default')
@section('title', 'Login')

@section('main')
  @component('components.page', [
    'modifiers' => ['page-login']
  ])
    @component('components.top-app-bar-surface', [
      'modifiers' => [
        'top-app-bar-surface--expanded',
        'top-app-bar-surface--min-height',
      ]
    ]) @endcomponent
    
    @layoutGridWithInner([
      'modifiers' => ['layout-grid--with-form-small']
    ])
        @cell([
        'when' => ['default' => 12],
        ])
            @card([
                'title' => 'Log In',
                'subtitle' => 'Ir para o Sistema',
                'actions' => [
                    [
                        'type' => 'button',
                        'props' => [
                            'text' => 'Esqueceu sua senha?',
                            'attrs' => [
                            ],
                        ],
                    ],
                ],
            ])
                @form([
                    'action' => url('/login'),
                    'method' => 'post',
                    'inputs' => [
                        [
                            'when' => ['default' => 12,],
                            'material' => 'textfield',
                            'props' => [
                                'label' => __('attrs.email'),
                                'attrs' => [
                                    'type' => 'email',
                                    'name' => 'email',
                                    'required' => '',
                                    'id' => 'textfield-email',
                                ],
                                'helperText' => [
                                    'isValidation' => true,
                                    'isPersistent' => $errors->has('auth'),
                                    'message' => $errors->get('auth')[0] ?? null,
                                ],
                            ],
                        ],
                        [
                            'when' => [
                                'default' => 12,
                            ],
                            'material' => 'textfield',
                            'props' => [
                                'label' => __('attrs.password'),
                                'attrs' => [
                                    'type' => 'password',
                                    'required' => '',
                                    'autocomplete' => 'off',
                                    'name' => 'password',
                                    'id' => 'textfield-password',
                                ],
                            ],
                        ],           
                    ],
                    'submit' => [
                        'text' => 'Entrar',
                        'modifiers' => ['mdc-button--unelevated'],
                        'attrs' => [
                            'type' => 'submit'
                        ],
                    ],        
                  ]) @endform              
            @endcard
        @endcell
    @endlayoutGridWithInner
  
  @endcomponent
@endsection 
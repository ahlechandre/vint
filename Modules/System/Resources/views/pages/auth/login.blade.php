@extends('layouts.default')
@section('title', 'Login')

@section('main')
  @component('components.ui.page', [
    'modifiers' => ['page-login']
  ])
    @component('components.ui.top-app-bar-surface', [
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
                                'disabled' => ''
                            ],
                        ],
                    ],
                ],
            ])
                @form([
                    'action' => url('/login'),
                    'method' => 'post',
                    'inputs' => [
                        'view' => 'system::inputs.login',
                        'props' => [
                            'email' => old('email')
                        ] 
                    ]        
                  ]) @endform              
            @endcard
        @endcell
    @endlayoutGridWithInner
  
  @endcomponent
@endsection 
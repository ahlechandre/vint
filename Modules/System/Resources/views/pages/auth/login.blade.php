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
    
    @component('material.layout-grid-with-inner', [
      'modifiers' => ['layout-grid--with-form-small']
    ])

      @component('material.cell', [
        'when' => [
          'default' => 12
        ],
      ])        
        @component('material.card', [
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
          @component('components.form', [
            'action' => url('/login'),
            'method' => 'post',
            'inputs' => [
              [
                'when' => [
                  'default' => 12,
                ],
                'material' => 'textfield',
                'props' => [
                  'label' => __('columns.user.identification_number'),
                  'attrs' => [
                    'type' => 'text',
                    'name' => 'identification_number',
                    'required' => '',
                    'id' => 'textfield-identification-number',
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
                  'label' => __('columns.password'),
                  'attrs' => [
                    'type' => 'password',
                    'required' => '',
                    'autocomplete' => 'off',
                    'name' => 'password',
                    'id' => 'textfield-password',
                  ],
                ],
              ],
              [
                'when' => [
                  'default' => 12,
                ],
                'material' => 'checkbox',
                'props' => [
                  'label' => 'Lembrar-me',
                  'attrs' => [
                    'name' => 'remember_me',
                    'id' => 'checkbox-remember-me',
                    'checked' => true,
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
          ]) @endcomponent
        @endcomponent

      @endcomponent
    @endcomponent
  
  @endcomponent
@endsection 
@formWithCard([
    'title' => $title,
    'subtitle' => $subtitle,
    'form' => [
        'attrs' => [
            'id' => 'form-user-password',
        ],
        'action' => $formAction,
        'method' => $formMethod,
        'cancel' => [
            'text' => __('actions.cancel'),
            'attrs' => [
                'href' => $formCancelUrl
            ]
        ],
        'submit' => [
            'icon' => 'check',
            'text' => __('actions.save'),
            'modifiers' => ['mdc-button--unelevated'],
            'attrs' => [
                'type' => 'submit'
            ],
        ],
        'inputsHidden' => $formInputsHidden ?? [],
        'inputs' => [ 
            [
                'material' => 'textfield',
                'when' => [
                    'desktop' => 6,
                    'tablet' => 8,
                ],
                'validation' => $validations['password'] ?? null,
                'props' => [
                    'label' => __('columns.password_new'),
                    'attrs' => [
                        'type' => 'password',
                        'name' => 'password',
                        'id' => 'textfield-user-password',
                        'required' => '',
                        'minlength' => 6
                    ],
                ],
            ],
            [
                'material' => 'textfield',
                'when' => [
                    'desktop' => 6,
                    'tablet' => 8,
                ],
                'validation' => $validations['password_confirmation'] ?? null,
                'props' => [
                    'label' => __('columns.password_confirmation'),
                    'attrs' => [
                        'type' => 'password',
                        'name' => 'password_confirmation',
                        'minlength' => 6,
                        'id' => 'textfield-user-password-confirmation',
                        'required' => '',
                    ],
                ],
            ],
        ],
    ],
]) @endformWithCard
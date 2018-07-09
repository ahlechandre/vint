@formWithCard([
    'title' => $title,
    'subtitle' => $subtitle,
    'form' => [
        'attrs' => [
            'id' => 'form-user-driver',
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
                'validation' => $validations['plate'] ?? null,
                'props' => [
                    'label' => __('columns.plate'),
                    'attrs' => [
                        'type' => 'text',
                        'name' => 'plate',
                        'id' => 'textfield-user-driver-plate',
                        'required' => '',
                        'value' => $values['plate'],
                    ],
                ],
            ],
            [
                'material' => 'textfield',
                'when' => [
                    'desktop' => 6,
                    'tablet' => 8,
                ],
                'validation' => $validations['points'] ?? null,
                'props' => [
                    'label' => __('columns.points'),
                    'attrs' => [
                        'type' => 'number',
                        'name' => 'points',
                        'id' => 'textfield-user-driver-points',
                        'step' => '0.01',
                        'value' => $values['points'],
                    ],
                ],
            ],
        ],
    ],
]) @endformWithCard
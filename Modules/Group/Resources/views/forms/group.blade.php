@formWithCard([
    'title' => $title,
    'subtitle' => $subtitle,
    'form' => [
        'attrs' => [
            'id' => 'form-group',
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
                    'desktop' => 12,
                    'tablet' => 8,
                    'phone' => 4
                ],
                'validation' => $validations['name'] ?? null,
                'props' => [
                    'label' => __('attrs.name'),
                    'attrs' => [
                        'type' => 'text',
                        'name' => 'name',
                        'id' => 'textfield-group-name',
                        'required' => '',
                        'value' => $values['name'],
                    ],
                ],
            ],
            [
                'material' => 'textfield-textarea',
                'when' => [
                    'desktop' => 12,
                    'tablet' => 8,
                    'phone' => 4
                ],
                'validation' => $validations['description'] ?? null,
                'props' => [
                    'label' => __('attrs.description'),
                    'attrs' => [
                        'name' => 'description',
                        'id' => 'textfield-group-description',
                        'required' => '',
                        'cols' => 100,
                        'rows' => 8,
                        'value' => $values['description'],
                    ],
                ],
            ],
            [
                'material' => 'switch',
                'when' => [
                    'desktop' => 12,
                    'tablet' => 8,
                ],
                'props' => [
                    'label' => __('attrs.is_active_switch'),
                    'attrs' => [
                        'name' => 'is_active',
                        'id' => 'textfield-group-is-active',
                        'checked' => $values['is_active'] ? true : false,
                    ]
                ]
            ]
        ]
    ]
]) @endformWithCard
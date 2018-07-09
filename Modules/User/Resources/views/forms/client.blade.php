@formWithCard([
    'title' => $title,
    'subtitle' => $subtitle,
    'form' => [
        'attrs' => [
            'id' => 'form-client',
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
                'validation' => $validations['name'] ?? null,
                'props' => [
                    'label' => __('columns.name'),
                    'attrs' => [
                        'type' => 'text',
                        'name' => 'name',
                        'id' => 'textfield-affiliate-name',
                        'required' => '',
                        'value' => $values['name'],
                    ],
                ],
            ],
            [
                'material' => 'textfield',
                'when' => [
                    'desktop' => 6,
                    'tablet' => 8,
                ],
                'validation' => $validations['email'] ?? null,
                'props' => [
                    'label' => __('columns.email'),
                    'attrs' => [
                        'type' => 'email',
                        'name' => 'email',
                        'id' => 'textfield-affiliate-email',
                        'value' => $values['email'],
                    ],
                ],
            ],
            [
                'material' => 'textfield',
                'when' => [
                    'desktop' => 12,
                    'tablet' => 8,
                ],
                'validation' => $validations['identification_number'] ?? null,
                'props' => [
                    'label' => __('columns.affiliate.identification_number'),
                    'helperText' => [
                        'isValidation' => false,
                        'isPersistent' => true,
                        'message' => 'Exemplo: 12345678901234',
                    ],
                    'attrs' => [
                        'name' => 'identification_number',
                        'id' => 'textfield-affiliate-identification_number',
                        'required' => '',
                        'minlength' => 14,
                        'maxlength' => 14,
                        'value' => $values['identification_number'],
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
                    'label' => __('columns.is_active_switch'),
                    'attrs' => [
                        'name' => 'is_active',
                        'id' => 'textfield-user-is-active',
                        'checked' => $values['is_active'] ? true : false,
                    ],
                ],
            ],

        ],
    ],
]) @endformWithCard
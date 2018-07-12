@formWithCard([
    'title' => $title,
    'subtitle' => $subtitle,
    'form' => [
        'attrs' => [
            'id' => 'form-user',
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
                    'desktop' => 8,
                    'tablet' => 4,
                    'phone' => 4
                ],
                'validation' => $validations['name'] ?? null,
                'props' => [
                    'label' => __('attrs.name'),
                    'attrs' => [
                        'type' => 'text',
                        'name' => 'name',
                        'id' => 'textfield-user-name',
                        'required' => '',
                        'value' => $values['name'],
                    ],
                ],
            ],
            [
                'material' => 'select',
                'when' => [
                    'desktop' => 4,
                    'tablet' => 4,
                    'phone' => 4
                ],
                'props' => [
                    'label' => __('attrs.role'),
                    'attrs' => [
                        'name' => 'role_id',
                        'id' => 'select-user-role',
                        'required' => '',
                    ],
                    'options' => $props['roles']->map(function ($role) use ($values) {
                        return [
                            'text' => $role->name,
                            'attrs' => [
                                'value' => $role->id,
                                'selected' => $values['role_id'] == $role->id,
                            ],
                        ];
                    })->prepend([
                        'text' => '',
                        'attrs' => [
                            'value' => '',
                            'disabled' => '',
                            'selected' => '',
                        ],
                    ])
                ],
            ],
            [
                'material' => 'textfield',
                'when' => [
                    'desktop' => 4,
                    'tablet' => 4,
                    'phone' => 4
                ],
                'validation' => $validations['username'] ?? null,
                'props' => [
                    'label' => __('attrs.username'),
                    'helperText' => [
                        'isPersistent' => true,
                        'isValidation' => false,
                        'message' => 'Por exemplo: alexandre_thebaldi.',
                    ],
                    'attrs' => [
                        'type' => 'text',
                        'name' => 'username',
                        'required' => '',
                        'pattern' => __('patterns.username'),
                        'id' => 'textfield-user-username',
                        'value' => $values['username']
                    ],
                ],
            ],            
            [
                'material' => 'textfield',
                'when' => [
                    'desktop' => 8,
                    'tablet' => 4,
                    'phone' => 4
                ],
                'validation' => $validations['email'] ?? null,
                'props' => [
                    'label' => __('attrs.email'),
                    'attrs' => [
                        'type' => 'email',
                        'name' => 'email',
                        'required' => '',
                        'id' => 'textfield-user-email',
                        'value' => $values['email'],
                    ],
                ],
            ],
            [
                'ignore' => $formMethod === 'put',
                'material' => 'textfield',
                'when' => [
                    'desktop' => 12,
                    'tablet' => 8,
                ],
                'validation' => $validations['password'] ?? null,
                'props' => [
                    'label' => __('attrs.password'),
                    'helperText' => [
                        'isPersistent' => true,
                        'isValidation' => false,
                        'message' => 'No mínimo 6 caracteres.',
                    ],
                    'attrs' => [
                        'type' => 'password',
                        'name' => 'password',
                        'id' => 'textfield-user-password',
                        'required' => '',
                        'minlength' => 6,
                        'value' => $values['password'] ?? null,
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
                        'id' => 'textfield-user-is-active',
                        'checked' => $values['is_active'] ? true : false,
                    ]
                ]
            ]
        ]
    ]
]) @endformWithCard
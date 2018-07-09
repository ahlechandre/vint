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
                    'desktop' => 12,
                    'tablet' => 8,
                ],
                'validation' => $validations['name'] ?? null,
                'props' => [
                    'label' => __('columns.name'),
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
                    'desktop' => 6,
                    'tablet' => 8,
                ],
                'props' => [
                    'label' => __('columns.role'),
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
                    'desktop' => 6,
                    'tablet' => 8,
                ],
                'validation' => $validations['identification_number'] ?? null,
                'props' => [
                    'label' => __('columns.user.identification_number'),
                    'helperText' => [
                        'isValidation' => false,
                        'isPersistent' => true,
                        'message' => 'Exemplo: 12345678901',
                    ],
                    'attrs' => [
                        'name' => 'identification_number',
                        'id' => 'textfield-user-identification_number',
                        'required' => '',
                        'minlength' => 11,
                        'maxlength' => 11,
                        'value' => $values['identification_number'],
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
                        'id' => 'textfield-user-email',
                        'value' => $values['email'],
                    ],
                ],
            ],
            [
                'ignore' => $formMethod === 'put',
                'material' => 'textfield',
                'when' => [
                    'desktop' => 6,
                    'tablet' => 8,
                ],
                'validation' => $validations['password'] ?? null,
                'props' => [
                    'label' => __('columns.password'),
                    'attrs' => [
                        'type' => 'password',
                        'name' => 'password',
                        'id' => 'textfield-user-password',
                        'required' => '',
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
                    'label' => __('columns.is_active_switch'),
                    'attrs' => [
                        'name' => 'is_active',
                        'id' => 'textfield-user-is-active',
                        'checked' => $values['is_active'] ? true : false,
                    ],
                ],
            ],
        ],
        // 'inputsGroups' => array_merge([], $props['role']->isAffiliateUser() ? [
        //     [
        //         'title' => 'Filial',
        //         'subtitle' => 'Indique os dados específicos do usuário de filial',
        //         'inputs' => [
        //             [
        //                 'material' => 'autocomplete',
        //                 'when' => [
        //                     'desktop' => 12,
        //                     'tablet' => 8,
        //                 ],
        //                 'validation' => $validations['affiliates'],
        //                 'props' => [
        //                     'isMultiple' => true,
        //                     'attrs' => [
        //                         'id' => 'autocomplete-user-affiliates',
        //                     ],
        //                     'textfield' => [
        //                         'label' => 'Filiais',
        //                         'attrs' => [
        //                             'type' => 'text',
        //                             'autocomplete' => 'nope', 
        //                             'id' => 'autocomplete-user-affiliates-textfield', 
        //                         ],
        //                     ]
        //                 ],
        //             ],
        //         ],
        //     ]
        // ] : [], $props['role']->isDriver() ? [
        //     [
        //         'title' => 'Motorista',
        //         'subtitle' => 'Indique os dados específicos do usuário motorista',
        //         'inputs' => [
        //             [
        //                 'when' => [
        //                     'desktop' => 6,
        //                     'tablet' => 8,
        //                 ],
        //                 'material' => 'textfield',
        //                 'props' => [
        //                     'label' => __('columns.plate'),
        //                     'validations' => $validations['driver']['plate'],
        //                     'attrs' => [
        //                         'type' => 'text',
        //                         'name' => 'driver[plate]',
        //                         'id' => 'textfield-user-driver-plate',
        //                         'required' => '',
        //                         'value' => $values['driver']['plate'],
        //                     ],
        //                 ]
        //             ],
        //             [
        //                 'when' => [
        //                     'desktop' => 6,
        //                     'tablet' => 8,
        //                 ],
        //                 'material' => 'textfield',
        //                 'props' => [
        //                     'label' => __('columns.points'),
        //                     'validations' => $validations['driver']['plate'],
        //                     'attrs' => [
        //                         'type' => 'number',
        //                         'name' => 'driver[points]',
        //                         'id' => 'textfield-user-driver-points',
        //                         'min' => 0,
        //                         'value' => $values['driver']['points'],
        //                     ],
        //                 ]
        //             ]
        //         ],
        //     ]            
        // ] : []),
    ],
]) @endformWithCard
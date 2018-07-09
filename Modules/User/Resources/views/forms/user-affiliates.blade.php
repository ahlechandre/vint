@formWithCard([
    'title' => $title,
    'subtitle' => $subtitle,
    'form' => [
        'attrs' => [
            'id' => 'form-user-affiliates',
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
                'material' => 'autocomplete',
                'when' => [
                    'desktop' => 12,
                    'tablet' => 8,
                ],
                'props' => [
                    'isMultiple' => true,
                    'inputName' => 'affiliates[]',
                    'values' => $values['affiliates'],
                    'attrs' => [
                        'id' => 'autocomplete-user-affiliates',
                    ],
                    'textfield' => [
                        'label' => 'Filiais',
                        'attrs' => [
                            'type' => 'text',
                            'autocomplete' => 'off', 
                            'id' => 'autocomplete-user-affiliates-textfield', 
                        ],
                    ]
                ],
            ],
        ],
    ],
]) @endformWithCard
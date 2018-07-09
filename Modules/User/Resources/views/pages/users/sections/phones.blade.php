@card([
    'title' => __('resources.phones'),
    'subtitle' => __('messages.user_phones.index'),
    'modifiers' => ['mdc-card--outlined'],
])
    @listTwoLine([
        'items' => $userToShow->phones->map(function ($phone) {
            return [
                'icon' => $phone->isMobile() ? 'smartphone' : 'phone', 
                'text' => $phone->forHumans(), 
                'secondaryText' => $phone->number,
                'metas' => [
                    [
                        'icon' => 'edit',
                        'attrs' => [
                            'href' => '#',
                            'title' => __('actions.edit'),
                            'id' => "dialog-activation-edit-phone-{$phone->id}"
                        ],
                    ],
                    [
                        'icon' => 'close',
                        'attrs' => [
                            'href' => '#',
                            'title' => __('actions.delete'),
                            'id' => "dialog-activation-destroy-phone-{$phone->id}"
                        ],
                    ] 
                ]
            ];
        })
    ]) @endlistTwoLine
@endcard

{{-- Phone Create Dialog --}}
<form action="{{ url("/users/{$userToShow->id}/phones") }}" method="post">
    @csrf

    @dialog([
        'activation' => 'dialog-activation-create-phone',
        'title' => __('messages.phones.create'),
        'attrs' => [
            'id' => 'dialog-create-phone',
        ],
        'cancel' => [
            'text' => __('actions.cancel'),
            'attrs' => [],
        ],
        'accept' => [
            'text' => __('actions.store'),
            'attrs' => [
                'type' => 'submit'
            ],
        ],        
    ])
        @layoutGridInner

            {{-- Tipo do telefone --}}
            @cell([
                'when' => [
                    'desktop' => 6,
                    'tablet' => 4,
                ]
            ])
                @select([
                    'label' => __('columns.phone_type'),
                    'attrs' => [
                        'name' => 'phone_type_id',
                        'required' => '',
                        'id' => 'textfield-user-phone-type',
                    ],
                    'options' => $phoneTypes->map(function ($phoneType) {
                        return [
                            'text' => $phoneType->name,
                            'attrs' => [
                                'value' => $phoneType->id,
                            ],
                        ];
                    })->prepend([
                        'text' => '',
                        'attrs' => [
                            'value' => '',
                            'disabled' => '',
                            'selected' => '',
                        ],
                    ]),
                ]) @endselect
            @endcell
            
            {{-- Operadora --}}
            @cell([
                'when' => [
                    'desktop' => 6,
                    'tablet' => 4,
                ]
            ])
                @select([
                    'label' => __('columns.telecommunication_company'),
                    'attrs' => [
                        'name' => 'telecommunication_company_id',
                        'id' => 'textfield-user-phone-telecommunication-company-id',
                    ],
                    'options' => $telecommunicationCompanies->map(function ($telecommunicationCompany) {
                        return [
                            'text' => $telecommunicationCompany->name,
                            'attrs' => [
                                'value' => $telecommunicationCompany->id,
                            ],
                        ];
                    })->prepend([
                        'text' => '',
                        'attrs' => [
                            'value' => '',
                            'selected' => '',
                        ],
                    ]),
                ]) @endselect
            @endcell
            
            {{-- Numero do telefone --}}
            @cell([
                'when' => [
                    'desktop' => 12,
                    'tablet' => 8,
                ]
            ])
                @textfield([
                    'label' => __('columns.phone.number'),
                    'helperText' => [
                        'isValidation' => false,
                        'isPersistent' => true,
                        'message' => 'Indique o número com DDD. Por exemplo: 66996224282.',
                    ],
                    'attrs' => [
                        'type' => 'tel',
                        'name' => 'number',
                        'required' => '',
                        'minlength' => 8,
                        'maxlength' => 12,
                        'id' => 'textfield-user-phone-number',
                    ],
                ]) @endtextfield
            @endcell

        @endlayoutGridInner
    @enddialog
</form>

{{-- Phone Edit Dialogs --}}
@foreach ($userToShow->phones as $phone)
    <form action="{{ url("/users/{$userToShow->id}/phones/{$phone->id}") }}" method="post">
        @csrf
        @method('put')

        {{-- Dialogs --}}
        @dialog([
            'activation' => "dialog-activation-edit-phone-{$phone->id}",
            'title' => 'Editar telefone',
            'attrs' => [
                'id' => "dialog-edit-phone-{$phone->id}",
            ],
            'cancel' => [
                'text' => __('actions.cancel'),
                'attrs' => [
                    'type' => 'button'                
                ],
            ],
            'accept' => [
                'text' => __('actions.update'),
                'attrs' => [
                    'type' => 'submit'
                ],
            ],
        ])
            @layoutGridInner

                {{-- Tipo do telefone --}}
                @cell([
                    'when' => [
                        'desktop' => 6,
                        'tablet' => 4,
                    ]
                ])
                    @select([
                        'label' => __('columns.phone_type'),
                        'attrs' => [
                            'name' => 'phone_type_id',
                            'required' => '',
                            'id' => "textfield-user-phone-type-edit-{$phone->id}",
                        ],
                        'options' => $phoneTypes->map(function ($phoneType) use ($phone) {
                            return [
                                'text' => $phoneType->name,
                                'attrs' => [
                                    'value' => $phoneType->id,
                                    'selected' => $phoneType->id === $phone->phone_type_id
                                ],
                            ];
                        }),
                    ]) @endselect
                @endcell
                
                {{-- Operadora --}}
                @cell([
                    'when' => [
                        'desktop' => 6,
                        'tablet' => 4,
                    ]
                ])
                    @select([
                        'label' => __('columns.telecommunication_company'),
                        'attrs' => [
                            'name' => 'telecommunication_company_id',
                            'id' => "textfield-user-phone-telecommunication-company-id-edit-{$phone->id}",
                        ],
                        'options' => $telecommunicationCompanies->map(function ($telecommunicationCompany) use ($phone) {
                            return [
                                'text' => $telecommunicationCompany->name,
                                'attrs' => [
                                    'value' => $telecommunicationCompany->id,
                                    'selected' => $telecommunicationCompany->id === $phone->telecommunication_company_id,
                                ],
                            ];
                        })->prepend([
                            'text' => '',
                            'attrs' => [
                                'value' => '',
                                'selected' => '',
                            ],
                        ]),
                    ]) @endselect
                @endcell
                
                {{-- Numero do telefone --}}
                @cell([
                    'when' => [
                        'desktop' => 12,
                        'tablet' => 8,
                    ]
                ])
                    @textfield([
                        'label' => __('columns.phone.number'),
                        'helperText' => [
                            'isValidation' => false,
                            'isPersistent' => true,
                            'message' => 'Indique o número com DDD. Por exemplo: 66996224282.',
                        ],
                        'attrs' => [
                            'type' => 'tel',
                            'name' => 'number',
                            'required' => '',
                            'minlength' => 8,
                            'maxlength' => 12,
                            'value' => $phone->number,
                            'id' => "textfield-user-phone-number-edit-{$phone->id}",
                        ],
                    ]) @endtextfield
                @endcell

            @endlayoutGridInner
        @enddialog
    
    </form>
@endforeach

{{-- Phone Destroy Dialogs --}}
@foreach ($userToShow->phones as $phone)
    <form action="{{ url("/users/{$userToShow->id}/phones/{$phone->id}") }}" method="post">
        @csrf
        @method('delete')

        {{-- Dialogs --}}
        @dialog([
            'activation' => "dialog-activation-destroy-phone-{$phone->id}",
            'title' => __('messages.phones.delete'),
            'attrs' => [
                'id' => "dialog-destroy-phone-{$phone->id}",
            ],
            'cancel' => [
                'text' => __('actions.cancel'),
                'attrs' => [
                    'type' => 'button'                        
                ],
            ],
            'accept' => [
                'text' => __('actions.delete'),
                'attrs' => [
                    'type' => 'submit'
                ],
            ],
        ])
            <p>
                Tem certeza que deseja remover o número "{{ $phone->number }}" de {{ $userToShow->name }}?
            </p>
        @enddialog
    </form>
@endforeach

@fab([
    'icon' => 'add',
    'label' => __('messages.phones.new'),
    'modifiers' => ['fab--fixed'],
    'attrs' => [
        'id' => 'dialog-activation-create-phone',
        'title' => __('messages.phones.new'),
        'alt' => __('messages.phones.new'),
    ],
]) @endfab

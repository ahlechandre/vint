@dialog([
    'activation' => $activation,
    'title' => $title,
    'attrs' => [
        'id' => $dialogId,
    ],
    'cancel' => [
        'text' => __('actions.cancel'),
        'attrs' => [
            'type' => 'button'
        ],
    ],
    'accept' => [
        'text' => $acceptText,
        'attrs' => [
            'type' => 'submit'
        ],
    ],        
])
    @layoutGridInner
        {{-- Descrição --}}
        @cell([
            'when' => [
                'desktop' => 12,
                'tablet' => 8,
            ]
        ])
            <p class="mdc-typography--subtitle1">
                {{ $description }}
            </p>
        @endcell

        {{-- Coordenador --}}
        @cell([
            'when' => [
                'desktop' => 12,
                'tablet' => 8,
            ]
        ])
            @select([
                'label' => 'Professor',
                'attrs' => [
                    'id' => 'select-group-create-coordinator',
                    'required' => '',
                    'name' => 'coordinator_user_id'
                ],
                'options' => $professors->map(function ($servant) {
                    return [
                        'text' => "{$servant->member->user->name} <{$servant->member->user->email}>",
                        'attrs' => [
                            'value' => $servant->member_user_id
                        ]
                    ];
                })->prepend([
                    'text' => '',
                    'attrs' => [
                        'disabled' => '',
                        'selected' => '',
                        'value' => ''
                    ]
                ])
            ]) @endselect
        @endcell

        {{-- É vice --}}
        @cell([
            'when' => [
                'desktop' => 12,
                'tablet' => 8,
            ]
        ])
            @checkbox([
                'label' => 'Vice coordenador',
                'attrs' => [
                    'name' => 'is_vice',
                    'id' => 'checkbox-group-create-coordinator-is-vice',
                ]
            ]) @endcheckbox
        @endcell        

    @endlayoutGridInner
@enddialog
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
                    'id' => 'select-group-update-coordinator',
                    'disabled' => '',
                ],
                'options' => [
                    [
                        'text' => "{$coordinator->member->user->name} <{$coordinator->member->user->email}>",
                        'attrs' => [
                            'disabled' => '',
                            'selected' => '',
                            'value' => '...'
                        ]
                    ]
                ]
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
                    'checked' => $coordinator->pivot->is_vice ? true : false,
                ]
            ]) @endcheckbox
        @endcell        

    @endlayoutGridInner
@enddialog
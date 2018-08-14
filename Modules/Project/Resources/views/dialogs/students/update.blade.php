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
                'label' => 'Aluno',
                'attrs' => [
                    'id' => "select-group-update-student-{$student->member_user_id}",
                    'disabled' => '',
                ],
                'options' => [
                    [
                        'text' => "{$student->member->user->name} <{$student->member->user->email}>",
                        'attrs' => [
                            'disabled' => '',
                            'selected' => '',
                            'value' => '...'
                        ]
                    ]
                ]
            ]) @endselect
        @endcell

        {{-- É bolsista --}}
        @cell([
            'when' => [
                'desktop' => 12,
                'tablet' => 8,
            ]
        ])
            @checkbox([
                'label' => 'Bolsista',
                'attrs' => [
                    'name' => 'is_scholarship',
                    'id' => "checkbox-group-update-student-is-scholarship-{$student->member_user_id}",
                    'checked' => $student->pivot->is_scholarship ? true : false,
                ]
            ]) @endcheckbox
        @endcell        

    @endlayoutGridInner
@enddialog
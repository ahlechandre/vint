@layoutGridInner
    @if ($groups ?? false)
        {{-- Grupo --}}
        @cell([
            'when' => ['d' => 12, 't' => 8, 'p' => 4]
        ])
            @select([
                'label' => __('attrs.group'),
                'helperText' => $validations['group_id'] ?? null,
                'attrs' => [
                    'name' => 'group_id',
                    'id' => 'textfield-program-group',
                ],
                'options' => $groups->map(function ($group) use ($groupId) {
                    return [
                        'text' => $group->name,
                        'attrs' => [
                            'value' => $group->id,
                            'selected' => (int) $groupId === $group->id
                        ],
                    ];
                })->prepend([
                    'text' => '',
                    'attrs' => [
                        'value' => '',
                        'selected' => '',
                        'disabled' => ''
                    ],
                ])
            ]) @endselect
        @endcell    
    @endif

    {{-- Nome --}}
    @cell([
        'when' => ['d' => 12, 't' => 8, 'p' => 4]
    ])
        @textfield([
            'label' => __('attrs.name'),
            'helperText' => $validations['name'] ?? null,
            'attrs' => [
                'type' => 'text',
                'name' => 'name',
                'id' => 'textfield-program-name',
                'required' => '',
                'value' => $name
            ],
        ]) @endtextfield
    @endcell

    {{-- Início em --}}
    @cell([
        'when' => ['d' => 6, 't' => 8, 'p' => 4]
    ])
        @textfield([
            'label' => __('attrs.start_on'),
            'helperText' => $validations['start_on'] ?? null,
            'attrs' => [
                'type' => 'date',
                'name' => 'start_on',
                'id' => 'textfield-program-start-on',
                'required' => '',
                'value' => $startOn
            ],
        ]) @endtextfield
    @endcell

    {{-- Final em --}}
    @cell([
        'when' => ['d' => 6, 't' => 8, 'p' => 4]
    ])
        @textfield([
            'label' => __('attrs.finish_on'),
            'helperText' => $validations['finish_on'] ?? null,
            'attrs' => [
                'type' => 'date',
                'name' => 'finish_on',
                'id' => 'textfield-program-finish-on',
                'value' => $finishOn
            ],
        ]) @endtextfield
    @endcell

    {{-- Coordenador --}}
    @cell([
        'when' => ['d' => 12, 't' => 8, 'p' => 4]
    ])
        @select([
            'label' => __('attrs.coordinator'),
            'helperText' => $validations['coordinator_user_id'] ?? null,
            'attrs' => [
                'name' => 'coordinator_user_id',
                'id' => 'textfield-program-coordinator',
            ],
            'options' => $servants->map(function ($servant) use ($coordinatorUserId) {
                return [
                    'text' => "{$servant->member->user->name} / {$servant->siape}",
                    'attrs' => [
                        'value' => $servant->member_user_id,
                        'selected' => (int) $coordinatorUserId === $servant->member_user_id
                    ],
                ];
            })->prepend([
                'text' => '',
                'attrs' => [
                    'value' => '',
                    'selected' => '',
                    'disabled' => ''
                ],
            ])
        ]) @endselect
    @endcell

    {{-- Description --}}
    @cell([
        'when' => ['d' => 12, 't' => 8, 'p' => 4]
    ])
        @textarea([
            'label' => __('attrs.description'),
            'helperText' => $validations['description'] ?? null,
            'attrs' => [
                'name' => 'description',
                'id' => 'textfield-program-description',
                'required' => '',
                'cols' => 100,
                'rows' => 6,
                'value' => $description
            ],
        ]) @endtextarea
    @endcell

@endlayoutGridInner
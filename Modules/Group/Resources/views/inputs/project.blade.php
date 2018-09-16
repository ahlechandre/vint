@gridInner    
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
                'id' => 'textfield-project-name',
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
                'id' => 'textfield-project-start-on',
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
                'id' => 'textfield-project-finish-on',
                'value' => $finishOn
            ],
        ]) @endtextfield
    @endcell

    {{-- Coordenador --}}
    @cell([
        'when' => ['d' => 6, 't' => 8, 'p' => 4]
    ])
        @select([
            'label' => __('attrs.coordinator'),
            'helperText' => $validations['coordinator_user_id'] ?? null,
            'attrs' => [
                'name' => 'coordinator_user_id',
                'id' => 'textfield-project-coordinator',
                'required' => ''
            ],
            'options' => $servantMembers->map(function ($member) use ($coordinatorUserId) {
                return [
                    'text' => "{$member->user->name} <{$member->user->email}>",
                    'attrs' => [
                        'value' => $member->user_id,
                        'selected' => (int) $coordinatorUserId === $member->user_id
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

    {{-- Programa --}}
    @cell([
        'when' => ['d' => 6, 't' => 8, 'p' => 4]
    ])
        @select([
            'label' => __('resources.program'),
            'helperText' => $validations['program_id'] ?? null,
            'attrs' => [
                'name' => 'program_id',
                'id' => 'textfield-project-program',
            ],
            'options' => $programs->map(function ($program) use ($programId) {
                return [
                    'text' => $program->name,
                    'attrs' => [
                        'value' => $program->id,
                        'selected' => (int) $programId === $program->id
                    ],
                ];
            })->prepend([
                'text' => '',
                'attrs' => [
                    'value' => '',
                    'selected' => '',
                ],
            ])
        ]) @endselect
    @endcell

    {{-- Orientador --}}
    @cell([
        'when' => ['d' => 6, 't' => 8, 'p' => 4]
    ])
        @select([
            'label' => __('attrs.leader'),
            'helperText' => $validations['leader_user_id'] ?? null,
            'attrs' => [
                'name' => 'leader_user_id',
                'id' => 'textfield-project-leader',
            ],
            'options' => $servantMembers->map(function ($member) use ($leaderUserId) {
                return [
                    'text' => "{$member->user->name} <{$member->user->email}>",
                    'attrs' => [
                        'value' => $member->user_id,
                        'selected' => (int) $leaderUserId === $member->user_id
                    ],
                ];
            })->prepend([
                'text' => '',
                'attrs' => [
                    'value' => '',
                    'selected' => '',
                ],
            ])
        ]) @endselect
    @endcell

    {{-- Apoiador --}}
    @cell([
        'when' => ['d' => 6, 't' => 8, 'p' => 4]
    ])
        @select([
            'label' => __('attrs.supporter'),
            'helperText' => $validations['supporter_user_id'] ?? null,
            'attrs' => [
                'name' => 'supporter_user_id',
                'id' => 'textfield-project-supporter',
            ],
            'options' => $collaboratorMembers->map(function ($member) use ($supporterUserId) {
                return [
                    'text' => "{$member->user->name} <{$member->user->email}>",
                    'attrs' => [
                        'value' => $member->user_id,
                        'selected' => (int) $supporterUserId === $member->user_id
                    ],
                ];
            })->prepend([
                'text' => '',
                'attrs' => [
                    'value' => '',
                    'selected' => '',
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
                'id' => 'textfield-project-description',
                'required' => '',
                'cols' => 100,
                'value' => $description
            ],
        ]) @endtextarea
    @endcell

@endgridInner
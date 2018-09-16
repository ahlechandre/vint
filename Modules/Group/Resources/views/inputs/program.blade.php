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
            'floatingLabelAbove' => true,
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
            'floatingLabelAbove' => true,
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
                'value' => $description
            ],
        ]) @endtextarea
    @endcell
@endgridInner